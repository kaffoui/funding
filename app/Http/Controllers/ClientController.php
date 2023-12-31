<?php

namespace App\Http\Controllers;

use App\Models\Pays;
use App\Models\User;
use App\Models\Client;
use App\Models\CarteCredit;
use App\Models\CompteBanque;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use DB;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;



class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Afficher les clients qui ont verifié leur compte par SMS
        $clients = DB::table('clients')
            ->join('users', 'users.id', '=', 'clients.user_id')
            ->select('users.*', 'clients.*')
            ->where('is_phone_valid', '=', '1')
            ->get();


        // Afficher tout les clients
       // $clients = Client::get();

        return view('dashboard.admin.clients.index', compact('clients'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.admin.clients.create');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Localisation curent user
        $adress_datas = $this->get_geolocation();

        // La validation
        $request->validate([
            'nom'         => ['required', 'string', 'max:255'],
            'prenoms'     => ['required', 'string', 'max:255'],
            'code_postal' => ['required', 'string', 'max:255'],
            'indicatif'   => ['required', 'string', 'max:255'],
            'email'       => ['required', 'email', 'max:255', 'unique:clients'],
            'ville'       => ['required', 'string', 'max:255'],
            'telephone'   => ['required', 'string', 'unique:users,telephone'],
            'password'    => ['required', 'min:8', 'confirmed'],
        ]);

        // recuperation pays user via code pour avoir l'identifiant du pays
        $paysUser = Pays::where('code', $adress_datas['country_code2'])->first();

        $request->merge([
            'telephone' => $paysUser->indicatif.$request->telephone,
        ]);




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
            'user_id'     => $user->id,
            'reference'   => Str::random(10),
            'nom'         => $request->nom,
            'prenoms'     => $request->prenoms,
            'code_postal' => $request->code_postal,
            'ville'       => $request->ville,
            'email'       => $request->email,
            'telephone'   => $request->telephone,
            'pays_id'     => $paysUser->id,

        ])->assignRole("Client");



        return redirect()->route('clients.index')->with('message', 'Client créé avec succès.');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
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

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
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
}
