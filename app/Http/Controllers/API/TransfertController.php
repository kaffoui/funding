<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Traits\FraisTrait;
use App\Http\Traits\SoldesTrait;
use App\Http\Traits\TauxTrait;
use App\Models\Pays;
use App\Models\Transfert;
use App\Models\User;
use App\Notifications\TransfertCreate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

// require $path = base_path('vendor/guzzlehttp/guzzle/src/Client.php');

class TransfertController extends Controller
{
    use FraisTrait, TauxTrait, SoldesTrait;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $transferts_from = auth()->user()->client->transferts_from;

        $transferts_to = auth()->user()->client->transferts_to;

        $transferts = collect($transferts_from)->merge($transferts_to)->sortByDesc('created_at');

        foreach ($transferts as $transfert) {
            if ($transfert->user_from->id != auth()->user()->id) {
                $transfert->montant = ($transfert->montant * $transfert->taux_to) - $transfert->frais;

                $transfert->user_from_nom = $transfert->user_from->noms();
            } else {
                $transfert->user_to_nom = $transfert->user_to->noms();
            }
        }

        return $transferts;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store2(Request $request)
    {
        try {
            $request->merge([
                'destinataire' => $request->pays . $request->destinataire,
            ]);
            $allowedPaymentMethods = ['Lisocash', 'CB', 'Orange', 'MTN', 'Airtel'];

            $regles = [
                "pays" => ['required', 'exists:pays,indicatif'],
                "destinataire" => ['required', 'exists:users,telephone'],
                "montant" => ['required', 'numeric', 'integer', 'min:1'],
                "paymentMethod" => ['required', Rule::in($allowedPaymentMethods)],
                "receptionMethod" => ['required', Rule::in($allowedPaymentMethods)],
            ];

            $messages = [
                'destinataire.exists' => 'Le destinataire n\'est pas un client ' . env('APP_NAME'),
            ];

            $destinataire = User::where('telephone', $request->destinataire)->first();

            $validator = Validator::make($request->all(), $regles, $messages);

            $validator->after(function ($validator) use ($request, $destinataire) {

                if ($destinataire) {
                    if (auth()->id() == $destinataire->id) {
                        $validator->errors()->add('destinataire', 'Impossible de faire le transfert vers cette destination.');
                    }

                    // On check le type de transfert lorsqu'il n'est pas entrain de demandé le resumé
                    if (!$request->resume) {
                        $allowedPaymentMethods = ['Lisocash', 'Carte', 'Orange', 'MTN', 'Airtel', 'CB'];

                        if (!in_array($request->paymentMethod, $allowedPaymentMethods)) {
                            $validator->errors()->add('paymentMethod', 'Méthode de paiement invalide');
                        }

                        // if ($request->paymentMethod == 'CB') {
                        //     if (!$request->paymentMethodId) {
                        //         $validator->errors()->add('paymentMethodId', 'Impossible de faire cette transaction sans carte de paiement');
                        //     }
                        // }
                    }

                    /**
                     * *S'il a les fonds suffisant
                     */
                    // On check s'il a solde s'il est entrain de faire un transfert par solde (avant ajout des frais)
                    if ($request->paymentMethod == 'Lisocash') {
                        if ($this->not_required_solde($request->montant) || $this->not_required_solde($request->montant)) {
                            $validator->errors()->add('montant', 'Solde insuffisant');
                        }
                    }
                    // if (!Hash::check($request->code_validation, auth()->user()->code_validation))
                    // {
                    //     $validator->errors()->add('code_validation', 'Code de validation invalide');
                    // }
                }
            });

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }

            $transfert_par_solde = true;

            $frais = $this->frais_get_frais_transfert(Transfert::class, auth()->user(), $destinataire);

            $montant_frais = $frais->frais_fixe ?: convertir_un_pourcentage_en_nombre($frais->frais_pourcentage, $request->montant);

            $taux_to = $this->taux_fetch_one(auth()->user()->pays->symbole_monnaie, $destinataire->pays->symbole_monnaie);

            $montant_envoyer = $request->montant;

            //check if could send money with fees
            if ($this->not_required_solde($montant_envoyer + $montant_frais)) {
                $validator->errors()->add('montant', 'Solde insuffisant');
                return response()->json(['errors' => $validator->errors()], 422);
            }

            // Montant que le destinataire recevra en sa monnaie
            $montant_recu = $this->taux_convert(auth()->user()->pays->symbole_monnaie, $destinataire->pays->symbole_monnaie, $request->montant);

            if ($this->user_europe_to_user_afrique(auth()->user()->pays->continent, $destinataire->pays->continent)) {
                sscanf($montant_recu, '%d%f', $int, $float);

                // TODO BAXE recoit le $float

                $montant_recu = $int + 1;
            }

            if ($request->resume == 1) { //Review here
                return response([
                    'data' => [
                        'destinataire' => $destinataire->noms(),
                        'frais' => round($montant_frais, 2),
                        'montant_total_transfert' => round($montant_envoyer + $montant_frais, 2),
                        'destinataire_recoit' => $montant_recu,
                        'monnaie_expediteur' => auth()->user()->pays->symbole_monnaie,
                        'monnaie_destinataire' => $destinataire->pays->symbole_monnaie,
                    ],
                    "success" => true,
                ], 200);
            }

            if ($request->paymentMethod == 'CB') {
                $transfert_par_solde = false;
            }

            // dd($request->montant);

            if ($transfert_par_solde == false) {
                try
                {
                    $frais_supplementaires = convertir_un_pourcentage_en_nombre(2, $request->montant);

                    if (auth()->user()->pays->continent != 'Africa') {
                        $montant = $montant_envoyer * 100;
                        $frais_supplementaires = $frais_supplementaires * 100;
                    }

                    $montant = $montant + $frais_supplementaires;

                    $montant = round($montant, 2);

                    // $stripeCharge = $request->user()->charge($montant, $request->paymentMethodId, [
                    //     'currency' => auth()->user()->pays->symbole_monnaie,
                    //     'description' => 'Transfert de ' . format_number_french($request->montant) . ' ' . auth()->user()->pays->symbole_monnaie . ' à ' . $destinataire->noms(),
                    //     'receipt_email' => $request->user()->email,
                    // ]);
                } catch (\Throwable $th) {
                    // dd($th);
                    return response([
                        'message' => "Transfert échoué. Veuillez réessayer plus tard.",
                        "success" => false,
                    ], 403);
                }
            }

            $this->transfert(auth()->user(), $destinataire, $montant_envoyer, $montant_frais, $taux_to, $montant_recu, 1, $transfert_par_solde, $request->paymentMethod, $request->receptionMethod);

            $message = 'Vous venez d’envoyer ' . format_number_french($request->montant, 2) . ' ' . auth()->user()->pays->symbole_monnaie . ' à ' . $destinataire->noms() . ' via ' . env('APP_NAME') . '. Votre nouveau  solde : ' . format_number_french(auth()->user()->soldes->last()->actuel) . ' ' . auth()->user()->pays->symbole_monnaie . '. ' . env('APP_NAME') . ' vous remercie pour votre fidélité.';

            return response()->json([
                'message' => $message,
                'solde' => $this->get_solde(),
                "success" => true,
            ], 200);
        } catch (\Throwable $th) {
            return response($th);
        }

    }

    public function store(Request $request)
    {
        $request->merge([
            'destinataire' => $request->pays . $request->destinataire,
        ]);

        $regles = [
            "pays" => ['required', 'exists:pays,indicatif'],
            "destinataire" => ['required', 'exists:users,telephone'],
            "montant" => ['required', 'numeric', 'integer', 'min:1'],
            // "code_validation" => ['required'],
        ];

        $messages = [
            'destinataire.exists' => 'Le destinataire n\'est pas un client ' . env('APP_NAME'),
        ];

        $destinataire = User::where('telephone', $request->destinataire)->first();

        $validator = Validator::make($request->all(), $regles, $messages);

        $validator->after(function ($validator) use ($request, $destinataire) {

            if ($destinataire) {
                if (auth()->id() == $destinataire->id) {
                    $validator->errors()->add('destinataire', 'Impossible de faire le transfert vers cette destination.');
                }

                // On check le type de transfert lorsqu'il n'est pas entrain de demandé le resumé
                if (!$request->resume) {
                    if ($request->payement_method != 'solde' && $request->payement_method != 'carte') {
                        $validator->errors()->add('payement_method', 'Méthode de paiement invalide');
                    }

                    if ($request->payement_method == 'carte') {
                        if (!$request->paymentMethodId) {
                            $validator->errors()->add('paymentMethodId', 'Impossible de faire cette transaction sans carte de paiement');
                        }
                    }
                }

                /**
                 * *S'il a les fonds suffisant
                 */
                // On check s'il a solde s'il est entrain de faire un transfert par solde
                if ($request->payement_method == 'solde') {
                    if ($this->not_required_solde($request->montant) || $this->not_required_solde($request->montant)) {
                        $validator->errors()->add('montant', 'Solde insuffisant');
                    }
                }

                // if (!Hash::check($request->code_validation, auth()->user()->code_validation))
                // {
                //     $validator->errors()->add('code_validation', 'Code de validation invalide');
                // }
            }
        });

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $transfert_par_solde = true;

        $frais = $this->frais_get_frais_transfert(Transfert::class, auth()->user(), $destinataire);

        $montant_frais = $frais->frais_fixe ?: convertir_un_pourcentage_en_nombre($frais->frais_pourcentage, $request->montant);

        $taux_to = $this->taux_fetch_one(auth()->user()->pays->symbole_monnaie, $destinataire->pays->symbole_monnaie);

        $montant_envoyer = $request->montant;

        //check if could send money with fees
        if ($this->not_required_solde($montant_envoyer + $montant_frais)) {
            $validator->errors()->add('montant', 'Solde insuffisant');
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Montant que le destinataire recevra en sa monnaie
        $montant_recu = $this->taux_convert(auth()->user()->pays->symbole_monnaie, $destinataire->pays->symbole_monnaie, $request->montant);

        if ($this->user_europe_to_user_afrique(auth()->user()->pays->continent, $destinataire->pays->continent)) {
            sscanf($montant_recu, '%d%f', $int, $float);

            // TODO BAXE recoit le $float

            $montant_recu = $int + 1;
        }

        if ($request->resume == 1) {
            return response([
                'data' => [
                    'destinataire' => $destinataire->noms(),
                    'frais' => round($montant_frais, 2),
                    'montant_total_transfert' => round($montant_envoyer + $montant_frais, 2),
                    'destinataire_recoit' => $montant_recu,
                    'monnaie_expediteur' => auth()->user()->pays->symbole_monnaie,
                    'monnaie_destinataire' => $destinataire->pays->symbole_monnaie,
                ],
            ], 200);
        }

        if ($request->payement_method == 'carte') {
            $transfert_par_solde = false;
        }

        // dd($request->montant);

        if ($transfert_par_solde == false) {
            try
            {
                $frais_supplementaires = convertir_un_pourcentage_en_nombre(2, $request->montant);

                if (auth()->user()->pays->continent != 'Africa') {
                    $montant = $montant_envoyer * 100;

                    $frais_supplementaires = $frais_supplementaires * 100;
                }

                $montant = $montant + $frais_supplementaires;

                $montant = round($montant, 2);

                $stripeCharge = $request->user()->charge($montant, $request->paymentMethodId, [
                    'currency' => auth()->user()->pays->symbole_monnaie,
                    'description' => 'Transfert de ' . format_number_french($request->montant) . ' ' . auth()->user()->pays->symbole_monnaie . ' à ' . $destinataire->noms(),
                    'receipt_email' => $request->user()->email,
                ]);
            } catch (\Throwable $th) {
                // dd($th);
                return response([
                    'message' => "Transfert échoué. Veuillez réessayer plus tard.",
                ], 403);
            }
        }

        $this->transfert(auth()->user(), $destinataire, $montant_envoyer, $montant_frais, $taux_to, $montant_recu, 1, $transfert_par_solde);

        $message = 'Vous venez d’envoyer ' . format_number_french($request->montant, 2) . ' ' . auth()->user()->pays->symbole_monnaie . ' à ' . $destinataire->noms() . ' via ' . env('APP_NAME') . '. Votre nouveau  solde : ' . format_number_french(auth()->user()->soldes->last()->actuel) . ' ' . auth()->user()->pays->symbole_monnaie . '. ' . env('APP_NAME') . ' vous remercie pour votre fidélité.';

        return response()->json([
            "success" => true,
            'message' => $message,
            'solde' => $this->get_solde(),
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Si on precise pas les frais, les taux c'est qu'ils sont dans le meme pays
     * Sinon on precise
     *
     * @param  mixed $user_from
     * @param  mixed $user_to
     * @param  mixed $montant_envoyer
     * @param  mixed $frais
     * @param  mixed $taux_to
     * @param  mixed $montant_recu
     * @param  mixed $taux_from
     * @param  mixed $transfert_par_solde
     * @return void
     */
    protected function transfert(User $user_from, User $user_to, $montant_envoyer, $frais, $taux_to, $montant_recu, $taux_from = 1, $transfert_par_solde = true, $paymentMethod, $receptionMethod)
    {

        if ($paymentMethod == "CB") {

        } else {
        switch ($receptionMethod) {
            case 'Lisocash':
                $transfert = Transfert::create([
                    'reference' => Str::random(10),
                    'user_id_from' => $user_from->id,
                    'user_id_to' => $user_to->id,
                    'montant' => $montant_envoyer,
                    'frais' => $frais,
                    'taux_from' => $taux_from,
                    'taux_to' => $taux_to,
                    'pays_from' => env('APP_ENV') == 'production' ? $this->get_geolocation()['country_code2'] : $user_from->pays->code,
                    'pays_to' => $user_to->pays->code,
                    'ip_from' => env('APP_ENV') == 'production' ? request()->ip() : $user_from->ip_register,
                    'ip_to' => $user_to->recent_ip,
                ]);

                // TODO Recuperation des beneficies liés aux frais et aux taux

                if ($transfert) {
                    if ($paymentMethod != "CB") {
                        $this->set_solde($user_from, $transfert->id, Transfert::class, $transfert_par_solde ? $this->new_solde_user_is_from($montant_envoyer + $frais) : ($this->get_solde() ? $this->get_solde()->actuel : 0));
                    }

                    $this->set_solde($user_to, $transfert->id, Transfert::class, $this->new_solde_user_is_to($user_to, $montant_recu));

                    $libelle_user_from = 'Transfert à ' . $user_to->noms() . '.';

                    $message_user_from = 'Vous avez transféré ' . format_number_french($montant_envoyer, 2) . ' ' . $user_from->pays->symbole_monnaie . ' à ' . $user_to->noms() . ' via ' . env('APP_NAME') . '.<br><br> Votre nouveau  solde : ' . format_number_french($user_from->soldes->last()->actuel) . ' ' . $user_from->pays->symbole_monnaie . '.';

                    /**
                     * user_from à true pour affiché la facture
                     * user_to à false pour ne pas afficher la facture et affiché que le mail markdown de laravel
                     */
                    $params = ['transfert_mode' => $transfert_par_solde ? 'Solde ' . env('APP_NAME') : '', 'montant_recu' => $montant_recu, 'user_from' => true, 'user_to' => false];

                    $user_from->notify(new TransfertCreate($transfert, $user_from, $user_to, $libelle_user_from, $message_user_from, $params));

                    $libelle_user_to = 'Transfert de ' . $user_from->noms() . '.';

                    $message_user_to = 'Vous avez reçu ' . format_number_french($montant_recu, 2) . ' ' . $user_to->pays->symbole_monnaie . ' de ' . $user_from->noms() . ' via ' . env('APP_NAME') . '.<br><br> Votre nouveau  solde : ' . format_number_french($user_to->soldes->last()->actuel) . ' ' . $user_to->pays->symbole_monnaie . '.';

                    /**
                     * user_to a true pour afficher le mail markdown de laravel ainsi
                     * user_from false pour ne pas afficher la facture pour le destinataire
                     */
                    $params = ['user_to' => true, 'user_from' => false];

                    $user_to->notify(new TransfertCreate($transfert, $user_from, $user_to, $libelle_user_to, $message_user_to, $params));
                }
                break;

            case 'Orange':

                break;

            case "CB":

                break;

            case 'Airtel':
                require 'vendor/autoload.php';
                $headers = array(
                    'Content-Type' => 'application/json',
                    'Accept' => '*/*',
                    'X-Country' => 'UG',
                    'X-Currency' => 'UGX',
                    'Authorization' => 'Bearer  UCLcp1oeq44KPXr8X*******xCzki2w',
                );
                $client = \GuzzleHttpClient();

                $body = [
                    "subscriber" => [
                        "msisdn" => 702698414,
                    ],
                    "transaction" => [
                        "amount" => 12345,
                        "id" => 12968801260,
                    ],
                    "additional_info" => [
                        [
                            "key" => "remark",
                            "value" => "AIRTXXXXXX",
                        ],
                    ],
                    "reference" => 123456,
                    "pin" => "KYJExln8rZwb14G1K5UE5YF/lD7KheNUM171MUEG3/f/QD8nmNKRsa44UZkh6A4cR8+fV31D6A4LSwJ4Bz84T29ZDQlunqf/5J+peJ5YO8d5xFIA14pK1rU897WMS0m/D21qsju7w9uT/eab//BzkWkrDOpw5RumI4cxb0YD+o8=",
                ];

                $request_body = $body;

                try {
                    $response = $client->request('POST', 'https://openapiuat.airtel.africa/standard/v1/cashin/', array(
                        'headers' => $headers,
                        'json' => $request_body,
                    ));
                    return ($response->getBody()->getContents());
                } catch (GuzzleHttpExceptionBadResponseException $e) {
                    // handle exception or api errors.
                    return ($e->getMessage());
                }
// ...

                break;
            default:
                # code...
                break;
        }
        }


    }

    public function get_taux($pays_indicatif)
    {
        $pays = Pays::where('indicatif', $pays_indicatif)->first();

        if (!$pays) {
            return response()->json(['errors' => ['pays' => "Pays non trouvé"]], 404);
        }

        $taux = $this->taux_fetch_one(auth()->user()->pays->symbole_monnaie, $pays->symbole_monnaie);

        return response()->json(['data' => [
            'destinataire_taux' => $taux,
            'destinataire_monnaie' => $pays->symbole_monnaie,
        ]], 200);
    }

    public function get_destinataire($numero_telephone)
    {
        $destinataire = User::where('telephone', $numero_telephone)->first();

        if (!$destinataire || $destinataire->id == auth()->id()) {
            return response()->json(['errors' => ['destinataire' => 'Le destinataire n\'est pas client ' . env('APP_NAME')]], 404);
        }

        $frais = $this->frais_get_frais_transfert(Transfert::class, auth()->user(), $destinataire);

        $frais = [
            'frais_pourcentage' => $frais->frais_pourcentage,
            'frais_fixe' => $frais->frais_fixe,
        ];

        return response()->json(['data' => [
            'destinataire' => $destinataire->client,
            'frais' => $frais,
        ]], 200);
    }

    public function history(Request $request)
    {

        try {
            $transactions = auth()->user()->soldes->sortByDesc('created_at');

            if (request()->limite == "*") {
                $limite = $transactions->count();
            } elseif (is_numeric(request()->limite)) {
                $limite = request()->limite;
            } else {
                $limite = 10;
            }

            $historiques = collect();

            foreach ($transactions as $transaction) {
                if ($transaction->operation_type == 'App\Models\Depot') {
                    $depot = $transaction->depot;

                    $acteur = null;

                    $montant = $depot->montant;

                    if (auth()->id() == $depot->user_id_from) // Montant du distributeur
                    {
                        $montant = $transaction->ancien - $transaction->actuel;
                    } elseif (auth()->id() == $depot->user_id_to) // Montant du client
                    {
                        $montant = $transaction->actuel - $transaction->ancien;
                    }

                    if ($depot->user_id_from == $depot->user_id_to) // Affiche le texte rechargement par carte de crédit
                    {
                        $acteur = "Par carte de crédit";

                        $montant = $depot->montant; // On prends le montant du depot
                    } elseif (auth()->id() == $depot->user_id_from) // Affiche le client pour le distributeur
                    {
                        $acteur = 'À ' . $depot->user_to->noms();
                    } elseif (auth()->id() == $depot->user_id_to) // Affiche le distributeur pour le client
                    {
                        $acteur = 'Chez ' . $depot->user_from->distributeur->entreprise_nom;
                    } else {}

                    $historiques->push([
                        'type' => 'depot',
                        'user_from' => $depot->user_id_from,
                        'user_to' => $depot->user_id_to,
                        'created_at' => $depot->created_at->format('d-m-Y à H:i'),
                        'user' => $acteur,
                        'frais' => $depot->frais,
                        'montant' => $montant,
                        'total' => $montant + $depot->frais,
                    ]);
                } elseif ($transaction->operation_type == 'App\Models\Retrait') {
                    $retrait = $transaction->retrait;

                    $montant = $retrait->montant;

                    if (auth()->id() == $retrait->user_id_from) {
                        $acteur = 'Chez ' . $retrait->distributeur->distributeur->entreprise_nom;
                    } elseif (auth()->id() == $retrait->user_id_to) {
                        $acteur = 'De ' . $retrait->client->noms();
                    } else {}

                    if (auth()->id() == $retrait->user_id_from) // Le montant du client
                    {
                        $montant = $transaction->ancien - $transaction->actuel;
                    } elseif (auth()->id() == $retrait->user_id_to) // Le montant du distributeur
                    {
                        $montant = $transaction->actuel - $transaction->ancien;
                    } else {}

                    $historiques->push([
                        'type' => 'retrait',
                        'user_from' => $retrait->user_id_from,
                        'user_to' => $retrait->user_id_to,
                        'created_at' => $retrait->created_at->format('d-m-Y à H:i'),
                        'user' => $acteur,
                        'frais' => $retrait->frais,
                        'montant' => $montant,
                        'total' => $montant + $retrait->frais,
                    ]);
                } elseif ($transaction->operation_type == 'App\Models\Transfert') {
                    $transfert = $transaction->transfert;

                    $montant = $transfert->montant;

                    if (auth()->id() == $transfert->user_id_from) // Le nom du destinataire
                    {
                        $acteur = 'À ' . $transfert->user_to->noms();
                    } elseif (auth()->id() == $transfert->user_id_to) // Le nom de l'expediteur
                    {
                        $acteur = 'De ' . $transfert->user_from->noms();
                    }

                    if (auth()->id() == $transfert->user_id_from) // Le montant de l'expediteur
                    {
                        $montant = $transfert->montant;

                        $total = $montant + $transfert->frais;
                    } elseif (auth()->id() == $transfert->user_id_to) // Le montant du destinataire
                    {
                        $montant = $transaction->actuel - $transaction->ancien;

                        $total = $montant;
                    } else {}

                    $historiques->push([
                        'type' => 'transfert',
                        'user_from' => $transfert->user_id_from,

                        'created_at' => $transfert->created_at->format('d-m-Y à H:i'),
                        'user' => $acteur,
                        'frais' => auth()->id() == $transfert->user_id_from ? format_number_french($transfert->frais, 2) : '--',
                        'montant' => $montant,
                        'total' => $total,
                    ]);
                } elseif ($transaction->operation_type == 'App\Models\PaiementCommercant') {
                    $paiementCommercant = $transaction->paiement_commercant;
                    $montant = 0;
                    $acteur = '';
                    $frais = 0;

                    if (auth()->id() == $paiementCommercant->user_id_from) {
                        $acteur = 'Au commercant ' . $paiementCommercant->commercant->noms();
                        $montant = $paiementCommercant->montant;
                    } elseif (auth()->id() == $paiementCommercant->user_id_to) {
                        $acteur = 'Du client ' . $paiementCommercant->commercant->noms();
                        $montant = $transaction->actuel - $transaction->ancien;
                        $frais = $paiementCommercant->frais; //convert this to the shopkeeper change when payment can be made between different countries
                    }

                    $total = $montant;

                    $historiques->push([
                        'type' => 'transfert',
                        'user_from' => $paiementCommercant->client->noms(),
                        'user_to' => $paiementCommercant->commercant->noms(),
                        'created_at' => $paiementCommercant->created_at->format('d-m-Y à H:i'),
                        'user' => $acteur,
                        'frais' => $frais,
                        'montant' => $montant,
                        'icon' => 'fas fa-paper-plane text-primary fs-4',
                        'total' => $total,
                    ]);
                }
            }

            $transactions = $historiques;

            $transactions = create_pagination_with_collection($transactions, $limite);

            $transactions->withPath('solde');

            $commission_depot = null;
            $commission_retrait = null;
            $commission_total = null;

            if (Gate::allows('is-distributeur')) {
                $commission_depot = auth()->user()->commissions->where('operation_type', Depot::class)->where('statut', false)->sum('commission');

                $commission_reste_retirer = auth()->user()->commissions->where('operation_type', CommissionRetire::class)->where('statut', false)->sum('commission');

                $commission_retrait = auth()->user()->commissions->where('operation_type', Retrait::class)->where('statut', false)->sum('commission');

                $commission_total = $commission_depot + $commission_retrait + $commission_reste_retirer;
            }

            return response()->json([
                "success" => true,
                'commissions' => [
                    'depot' => $commission_depot,
                    'retrait' => $commission_retrait,
                    'total' => $commission_total,
                ],
                'historique' => $transactions,
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                "success" => false,
                "message" => "Un problème a été rencontré",
            ], 400);
        }

    }

}
