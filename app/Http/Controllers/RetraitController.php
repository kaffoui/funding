<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRetraitRequest;
use App\Http\Requests\UpdateRetraitRequest;
use App\Http\Traits\FraisTrait;
use App\Http\Traits\LocalisationTrait;
use App\Http\Traits\SoldesTrait;
use App\Http\Traits\TauxTrait;
use App\Models\Retrait;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class RetraitController extends Controller
{
    use SoldesTrait, TauxTrait, LocalisationTrait, FraisTrait;

    public function __construct()
    {
        // $this->middleware('code.confirmation')->only(['create', 'store']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('shared-pages.retrait.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('shared-pages.retrait.create');
    }

//RETRAIT
    public function withdrawal(Request $request)
    {
        // try {
        $apiUrl = request()->getHttpHost() . "/api";
        // dd($data);
        $data = $request->all();
        foreach ($data as $k => $v) {
            $data = $k;
        }

        $data = json_decode(json_encode($data));
        $data = Str::between($data, ':"', '}');
        $d["data"] = $data;

        $data = base64_decode(base64_decode($data));
        $data = Str::between($data, '"', '"');
        $data = json_decode(json_encode($data));
        $client_id = str_replace(' ', '', Str::between($data,'client_id:', ","));
        $client_montant = str_replace(' ', '', Str::between($data,'client_montant:', "}"));
        $client = User::find($client_id);
        if (!$client) {
            return response()->json([
                "success" => false,
                "message" => "Utilisateur invalide",
            ], 400);
        }

        if ($client_montant < 1) {
            return response()->json([
                "success" => false,
                "message" => "Montant invalide",
            ], 400);
        }

        // $validator = Validator::make($data, [
        //     'client_id'       => ['required', 'integer', 'exists:users,id'],
        //     'client_montant'  => ['required', 'numeric', 'min:1'],
        //     // 'resume'          => ['required', 'in:0,1'],
        //     // 'code_validation' => ['required'],
        // ]);

        // $validator->after(function ($validator) use ($client) {
        if ($this->not_required_solde($client_montant, $client)) {
            return response()->json([
                "success" => false,
                "message" => "Solde du client insuffisant",
            ], 422);
            // $validator->errors()->add('client_montant', 'Solde du client insuffisant');
        }

        $montant = $client_montant;

        if (!$this->same_country_users(auth()->user(), $client)) {
            $montant = (int) $this->taux_convert($client->pays->symbole_monnaie, auth()->user()->pays->symbole_monnaie, $montant);
        }
        // dd($montant);

        // Lorsqu'on arrive pas à recuperé la tranche de commission
        if (!($this->frais_get_commission_depot_distributeur(Retrait::class, auth()->user(), (int) $montant)) && $montant > 0) {
            return response()->json([
                "success" => false,
                "message" => "Désolé vous ne pouvez pas effectuer cette opération. \n Si vous pensez qu'il s'agit d'une erreur contacter le service client.",
            ], 422);
            // $validator->errors()->add('exeption_error', "Désolé vous ne pouvez pas effectuer cette opération. \n Si vous pensez qu'il s'agit d'une erreur contacter le service client.");
        }

        if (Gate::forUser($client)->denies('is-client')) {
            // $validator->errors()->add('client_id', "Impossible de faire le retrait de ce client.");
            return response()->json([
                "success" => false,
                "message" => "Impossible de faire le retrait de ce client",
            ], 422);
        }

        // if (!Hash::check(request()->code_validation, auth()->user()->code_validation))
        // {
        //     $validator->errors()->add('code_validation', 'Code de validation invalide');
        // }
        // });

        // if ($validator->fails()) {
        //     return response()->json(['errors' => $validator->errors()], 422);
        // }

        // Montant à mettre sur le compte du client
        $montant = $client_montant;

        if (!$this->same_country_users(auth()->user(), $client)) {
            $montant = (int) $this->taux_convert($client->pays->symbole_monnaie, auth()->user()->pays->symbole_monnaie, $montant);
        }

        if ($request->resume == 1) {
            $client->nom_prenoms = $client->client->noms();

            $client->montant = $montant;

            return response()->json([
                'data' => $client,
            ], 200);
        }

        $commission = $this->frais_get_commission_depot_distributeur(Retrait::class, auth()->user(), $montant);

        $commission = $commission->frais_fixe ?: convertir_un_pourcentage_en_nombre($commission->frais_pourcentage, $montant);

        $taux_to = $this->taux_fetch_one($client->pays->symbole_monnaie, auth()->user()->pays->symbole_monnaie);

        $retrait = Retrait::create([
            'reference' => Str::random(10),
            'user_id_from' => $client->id,
            'user_id_to' => auth()->id(),
            'montant' => $client_montant,
            'frais' => 0,
            'taux_from' => 1,
            'taux_to' => $taux_to,
            'pays_from' => env('APP_ENV') == 'production' ? $this->get_geolocation($client->recent_ip)['country_code2'] : $client->pays->code,
            'pays_to' => auth()->user()->pays->code,
            'ip_from' => $client->recent_ip,
            'ip_to' => env('APP_ENV') == 'production' ? request()->ip() : auth()->user()->recent_ip,
        ]);

        if ($retrait) {
            $this->set_solde($client, $retrait->id, Retrait::class, $this->new_solde_user_is_from($client_montant, $client));
            $this->set_solde(auth()->user(), $retrait->id, Retrait::class, $this->new_solde_user_is_to(auth()->user(), $montant));
            auth()->user()->commissions()->create([
                'operation_type' => Retrait::class,
                'operation_id' => $retrait->id,
                'commission' => $commission,
            ]);
        }

        $commission_retrait = auth()->user()->commissions->where('operation_type', Retrait::class)->where('statut', false)->sum('commission');

        $message = 'Vous venez de faire le retrait de ' . format_number_french($montant, 2) . ' ' . auth()->user()->pays->symbole_monnaie . ' de ' . $client->noms() . ' via ' . env('APP_NAME') . '. Votre nouveau  solde : ' . format_number_french(auth()->user()->soldes->last()->actuel, 2) . ' ' . auth()->user()->pays->symbole_monnaie . '. ' . env('APP_NAME') . ' vous remercie pour votre collaboration.';

        return response()->json([
            'data' => $retrait,
            'commission_retrait' => $commission_retrait,
            'message' => $message,
        ], 200);

        // $req = Request::create('/api/retrait','POST',$d);
        // $response = Route::dispatch($req);
        // dd($response->getContent());
        // $response = json_decode($response->getContent(),true);
        // // dd($data,$response);
        // if($response["success"]){
        //     return redirect()->back()->with([
        //         "success" => true,
        //         "message" => "Retrait réussi",
        //     ]);
        // }else if(!$response["success"]){
        //     return redirect()->back()->with([
        //         "success" => false,
        //         "message" => $response["message"],
        //     ]);
        // }
        // else{
        //     return redirect()->back()->with([
        //         "success" => false,
        //         "message" => "Impossible d'effectuer le retrait. Assurez-vous que le destinataire spécifié est un client Lisocash ou réessayez plus tard.",
        //     ]);
        // }
        // } catch (\Throwable $th) {
        //     return redirect()->back()->with([
        //         "success" => false,
        //         "message" => "Impossible d'effectuer le retrait. Assurez-vous que le destinataire spécifié est un client Lisocash ou réessayez plus tard.",
        //     ]);
        // }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreRetraitRequest  $request
     * @return \Illuminate\Http\Response
     */
    // public function store(StoreRetraitRequest $request)
    // {
    //     $client = User::find($request->client_id);

    //     $montant = $request->client_montant;

    //     if (!$this->same_country_users(auth()->user(), $client))
    //     {
    //         $montant = (int) $this->taux_convert($client->pays->symbole_monnaie, auth()->user()->pays->symbole_monnaie, $montant);
    //     }

    //     $commission = $this->frais_get_commission_depot_distributeur(Retrait::class, auth()->user(), $montant);

    //     $commission = $commission->frais_fixe ?: convertir_un_pourcentage_en_nombre($commission->frais_pourcentage, $montant);

    //     $taux_to = $this->taux_fetch_one($client->pays->symbole_monnaie, auth()->user()->pays->symbole_monnaie);

    //     $retrait = Retrait::create([
    //         'reference'    => Str::random(10),
    //         'user_id_from' => $client->id,
    //         'user_id_to'   => auth()->id(),
    //         'montant'      => $request->client_montant,
    //         'frais'        => 0,
    //         'taux_from'    => 1,
    //         'taux_to'      => $taux_to,
    //         'pays_from'    => env('APP_ENV') == 'production' ? $this->get_geolocation($client->recent_ip)['country_code2'] : $client->pays->code,
    //         'pays_to'      => auth()->user()->pays->code,
    //         'ip_from'      => $client->recent_ip,
    //         'ip_to'        => env('APP_ENV') == 'production' ? request()->ip() : auth()->user()->recent_ip
    //     ]);

    //     if ($retrait)
    //     {
    //         $this->set_solde($client, $retrait->id, Retrait::class, $this->new_solde_user_is_from($request->client_montant, $client));

    //         $this->set_solde(auth()->user(), $retrait->id, Retrait::class, $this->new_solde_user_is_to(auth()->user(), $montant));

    //         auth()->user()->commissions()->create([
    //             'operation_type' => Retrait::class,
    //             'operation_id' => $retrait->id,
    //             'commission' => $commission
    //         ]);
    //     }

    //     $message = 'Vous venez de faire le retrait de '.format_number_french($montant, 2).' '.auth()->user()->pays->symbole_monnaie.' de '.$client->noms().' via '.env('APP_NAME').'.<br><br> Votre nouveau  solde : '.format_number_french(auth()->user()->soldes->last()->actuel, 2).' '.auth()->user()->pays->symbole_monnaie.'.<br><br>'.env('APP_NAME').' vous remercie pour votre collaboration.';

    //     /**
    //      * On retourne le message parce que la redirection se fait en JS apre la requete AJAX, ce qui fait la session flashé ne passe vue qu'il fait la redirection comme si on a cliqué sur un lien
    //      */
    //     if ($request->ajax())
    //     {
    //         return $message;
    //     }

    //     $request->session()->flash('message', $message);

    //     return redirect()->route('distributeur.retrait.index');
    // }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Retrait  $retrait
     * @return \Illuminate\Http\Response
     */
    public function show(Retrait $retrait)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Retrait  $retrait
     * @return \Illuminate\Http\Response
     */
    public function edit(Retrait $retrait)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateRetraitRequest  $request
     * @param  \App\Models\Retrait  $retrait
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRetraitRequest $request, Retrait $retrait)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Retrait  $retrait
     * @return \Illuminate\Http\Response
     */
    public function destroy(Retrait $retrait)
    {
        //
    }
}
