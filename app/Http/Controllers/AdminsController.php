<?php

namespace App\Http\Controllers;

use App\Models\Pays;
use App\Models\User;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $administrateurs = User::where('role', '>', '0');
        return view('dashboard.admin.utilisateur.index', compact('administrateurs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
         // La validation
         $validator = Validator::make($request->all(), [
            'nom' => ['required', 'string', 'max:255'],
            'prenoms' => ['required', 'string', 'max:255'],
            'code_postal' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users'],
            'ville' => ['required', 'string', 'max:255'],
            'password' => ['required', 'min:8', 'confirmed'],
            'indicatif' => ['required'],
            "telephone" => ["required"],
        ]);

        $paysUser = Pays::where('indicatif', $request->indicatif)->first();
        $telephone = $paysUser->indicatif . $request->telephone;
        $validator->after(function ($validator) use ($request, $telephone) {
            // if (str_starts_with($request->telephone, '00') || str_starts_with($request->telephone, '+'))
            // {
            //     $validator->errors()->add('telephone', "La valeur du champ doit être saisi sans l'indicatif du pays.");
            // }

            // $adress_datas = $this->get_geolocation();

            // recuperation pays user via code pour avoir l'identifiant du pays
            // $paysUser = Pays::where('code', $request->code_pays)->first();

            // // $telephone = $paysUser->indicatif.$request->telephone;
            // $telephone = $request->telephone;

            if (User::where('telephone', $telephone)->first()) {
                $validator->errors()->add('telephone', "La valeur du champ est déjà utilisée.");
                return redirect()->back()->with([
                    "success" => false,
                    "message" => "La valeur du champ est déjà utilisée"
                ]);
            }
        });

        if ($validator->fails()) {
            dd($validator->errors());
            return redirect()->back()->with([
                "success" => false,
                "message" =>  "Oops ! Un problème a été rencontré lors de l'opération"
            ]);
        }

        // $adress_datas = $this->get_geolocation();

        // recuperation pays user via code pour avoir l'identifiant du pays
        // $paysUser = Pays::where('code', $adress_datas['country_code2'])->first();

        $telephone = str_replace(' ', '', $telephone);

        // nouvel user pour les infos de connexion
        $user = User::create([
            'pays_register_id' => $paysUser->id,
            'ip_register' => request()->ip(),
            'email' => strtolower($request->email),
            'telephone' => $telephone,
            'recent_ip' => request()->ip(),
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'code_validation' => $request->code_validation,
            'email_verified_at' => date('Y-m-d H:i:s'),
        ]);

        //send phone first
        $code = generateRandomNumber();
        $user->update(["sms_code" => $code]);
        try {
            send_code("sms", $telephone, $code, "inscription");
        } catch (\Throwable $th) {
            try {
                send_code("sms", $telephone, $code, "inscription");
            } catch (\Throwable $th) {
                dd($th);
            }
        }
        // send other code and send email then
        $code = generateRandomNumber();
        $user->update(["email_code" => $code]);
        try {
            send_code("mail", strtolower($request->email), $code, "inscription");
        } catch (\Throwable $th) {
            try {
                send_code("mail", strtolower($request->email), $code, "inscription");
            } catch (\Throwable $th) {
            }
        }

        // event(new Registered($user));

        return redirect()->route('validateSmsCodeForm')->with([
            'success' => true,
            "message" => "Un code a été envoyé au ". $telephone .". Consultez votre messagerie sms ainsi que votre boite de réception email afin de valider votre inscription.",
            "phone" => $telephone
        ]);
        // }
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
