<?php

namespace App\Http\Controllers;

use DB;
use App\Models\Pays;
use App\Models\User;
use App\Models\Client;
use App\Models\Employe;
use App\Models\CarteCredit;
use App\Models\Departement;
use Illuminate\Support\Str;
use App\Models\CompteBanque;
use App\Models\Distributeur;
use Illuminate\Http\Request;
use App\Notifications\EmployeCree;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Auth\Events\Registered;


class AdminController extends Controller
{

    public function statistiques() {

        return view('dashboard.admin.statistiques');

    }

    public function liste_clients() {

        $clients = Client::all();

        return view('dashboard.admin.clients.index', compact('clients'));

    }

    public function details_client($id) {

        $carte_credits = CarteCredit::where('user_id',$id)
            ->where('statut', '=', '1')
            ->get();

        $compte_banques = CompteBanque::where('user_id',$id)
            ->where('statut', '=', '1')
            ->get();

        $clients_infos = DB::table('clients')
            ->join('pays', 'pays.id', '=', 'clients.pays_id')
            ->select('pays.nom as nom_pays', 'clients.*')
            ->where('user_id',$id)
            ->get();

        return view('dashboard.admin.clients.show', compact('carte_credits', 'compte_banques', 'clients_infos'));
    }



    public function  client_create(){
        return view('dashboard.admin.clients.create');
    }

    public function client_store(Request $request){
        // Localisation curent user
        $adress_datas = $this->get_geolocation();

        // recuperation pays user via code pour avoir l'identifiant du pays
        $paysUser = Pays::where('code', $adress_datas['country_code2'])->first();

        $request->merge([
            'telephone' => $paysUser->indicatif.$request->telephone,
        ]);

        // La validation
        $validator = Validator::make($request->all(), [
            'nom'         => ['required', 'string', 'max:255'],
            'prenoms'     => ['required', 'string', 'max:255'],
            'code_postal' => ['required', 'string', 'max:255'],
            'email'       => ['required', 'email', 'max:255', 'unique:clients'],
            'ville'       => ['required', 'string', 'max:255'],
            'telephone'   => ['required', 'string', 'unique:users,telephone'],
            'password'    => ['required', 'min:8', 'confirmed'],
        ]);

        if ($validator->fails())
        {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        // nouvel user pour les infos de connexion
        $user = User::create([
            'pays_register_id' => $paysUser->id,
            'ip_register'      => $adress_datas['ip'],
            'email'            => $request->email,
            'telephone'        => $request->telephone,
            'recent_ip'        => $adress_datas['ip'],
            'password'         => Hash::make($request->password)
        ]);
        // nouvel client
        $client = Client::create([
            'reference'   => Str::random(10),
            'nom'         => $request->nom,
            'prenoms'     => $request->prenoms,
            'code_postal' => $request->code_postal,
            'ville'       => $request->ville,
            'email'       => $request->email,
            'telephone'   => $request->telephone,
            'pays_id'     => $paysUser->id,
            'user_id'     => $user->id,
        ]);
        // user token
        $token = $user->createToken('API Token Login')->plainTextToken;
        event(new Registered($user));
        // Return new client JSON
        return response(['client' => $client, 'pays' => $user->pays, 'token' => $token]);
    }




    //utilisateurs
    public function utilisateur_registeurs(){

    }



    // Employes


    public function liste_employes()
    {
        $employes = Employe::all();

        return view('dashboard.admin.utilisateurs.index', compact('employes'));
    }





    public function employe_create()
    {
        $pays = Pays::orderBy('nom')->get();

        $departements = Departement::orderBy('nom')->get();

        $situations_matrimoniales = [
            'Célibataire',
            'Marié(e)',
            'Divorcé(e)',
            'Veuf(ve)',
        ];

        $genres = [
            'Masculin',
            'Féminin',
        ];

        return view('admin.employe.create', compact('pays', 'departements', 'situations_matrimoniales', 'genres'));
    }

    public function employe_store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nom'                    => ['required', 'string', 'max:255'],
            'prenoms'                => ['required', 'string', 'max:255'],
            'genre'                  => ['required', 'string', 'max:255', 'in:Masculin,Féminin'],
            'situation_matrimoniale' => ['required', 'string', 'max:255', 'in:Célibataire,Marié(e),Divorcé(e),Veuf(ve)'],
            'email'                  => ['required', 'string', 'email', 'max:255', 'unique:employes,email', 'unique:users,email'],
            'pays'                   => ['required', 'integer', 'exists:pays,id'],
            'ville'                  => ['required', 'string', 'max:255'],
            'adresse'                => ['required', 'string', 'max:255'],
            'departement'            => ['required', 'integer', 'exists:departements,id'],
        ]);

        $validator->after(function ($validator) use ($request) {
            $pays = Pays::find($request->pays);

            $telephone = $pays->indicatif.$request->telephone;

            if (str_starts_with($request->telephone, '00') || str_starts_with($request->telephone, '+'))
            {
                $validator->errors()->add('telephone', "La valeur du champ doit être saisi sans l'indicatif du pays.");
            }

            if (User::where('telephone', $telephone)->exists() || Employe::where('telephone', $telephone)->exists())
            {
                $validator->errors()->add('telephone', 'La valeur du champ est déjà utilisée.');
            }
        });

        if ($validator->fails())
        {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $mot_de_passe = Str::random(10);

        $pays = Pays::find($request->pays);

        if ($request->creation_acces)
        {
            $user = User::create([
                'pays_register_id' => $request->pays,
                'ip_register'      => '127.0.0.1',
                'email'            => strtolower($request->email),
                'telephone'        => str_replace(' ', '', $pays->indicatif.$request->telephone),
                'recent_ip'        => '127.0.0.1',
                'password'         => Hash::make($mot_de_passe),
            ]);

            $user->mot_de_passe = $mot_de_passe;

            $user->notify(new EmployeCree($user));
        }

        $employe = Employe::create([
            'user_id'                => isset($user) ? $user->id : null,
            'pays_id'                => $request->pays,
            'nom'                    => ucfirst(strtolower($request->nom)),
            'prenoms'                => ucfirst(strtolower($request->prenoms)),
            'genre'                  => ucfirst(strtolower($request->genre)),
            'situation_matrimoniale' => ucfirst(strtolower($request->situation_matrimoniale)),
            'telephone'              => str_replace(' ', '', $pays->indicatif.$request->telephone),
            'email'                  => strtolower($request->email),
            'ville'                  => ucfirst(strtolower($request->ville)),
            'adresse'                => ucfirst(strtolower($request->adresse)),
        ]);

        $employe->departements()->attach($request->departement);

        return redirect()->route('admin.employe.index')->with('message', 'Employé créé avec succès.');
    }

    public function set_droit_distributeur(User $user)
    {
        Distributeur::create([
            'reference'             => Str::random(8),
            'user_id'               => $user->id,
            'pays_id'               => $user->pays_register_id,
            'nom'                   => ucfirst(strtolower($user->employe->nom)),
            'prenoms'               => ucfirst(strtolower($user->employe->prenoms)),
            'code_postal'           => rand(10000, 99999),
            'ville'                 => ucfirst(strtolower($user->employe->ville)),
            'email'                 => strtolower($user->email),
            'telephone'             => str_replace(' ', '', $user->employe->telephone),
            'activite_principale'   => 'Gestionnaire de compte chez Baxe',
            'entreprise_nom'        => 'Baxe',
            'path_piece_identitite' => json_encode([]),
            'communication_baxe'    => 'Interne'
        ]);

        return redirect()->route('admin.employe.index')->with('message', "Le gestionnaire de compte peut maintenant effectuer des opérations de distributeur.");
    }


}
