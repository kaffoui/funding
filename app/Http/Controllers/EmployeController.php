<?php

namespace App\Http\Controllers;

use App\Models\Pays;
use App\Models\User;
use App\Models\Employe;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Validator;

class EmployeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $employes = Employe::all();

        return view('dashboard.admin.utilisateurs.index', compact('employes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::all();
        $permissions = Permission::all();
        $payss = Pays::orderBy('nom', 'asc')->get();
        return view('dashboard.admin.utilisateurs.create', compact('roles','permissions','payss'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nom'                    => ['required', 'string', 'max:255'],
            'prenoms'                => ['required', 'string', 'max:255'],
            'code_postal'                  => ['required', 'string', 'max:255'],
            'indicatif' => ['required', 'string', 'max:255'],
            'telephone' => ['required', 'string', 'max:255'],
            'email'                  => ['required', 'string', 'email', 'max:255', 'unique:employes,email', 'unique:users,email'],
            'pays'                   => ['required', 'integer', 'exists:pays,id'],
            'ville'                  => ['required', 'string', 'max:255'],
            'email'                => ['required', 'string', 'max:255'],
            'role'                => ['required', 'string', 'max:255'],
            // 'permissions'                => ['required', 'string', 'max:255'],
            'password'                => ['required', 'string', 'max:255'],
            'password_confirmation'                => ['required', 'string', 'max:255', 'same:password'],
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



        $pays = Pays::find($request->pays);


            $user = User::create([
                'pays_register_id' => $request->pays,
                'ip_register'      => '127.0.0.1',
                'email'            => strtolower($request->email),
                'telephone'        => str_replace(' ', '', $pays->indicatif.$request->telephone),
                'recent_ip'        => '127.0.0.1',
                'password'         => Hash::make($request->password),
                'is_email_valid'        => '1',
                'is_phone_valid'        => '1',
            ])->assignRole($request->role);

            // $user->mot_de_passe = $mot_de_passe;

            // $user->notify(new EmployeCree($user));
            // $role = $request->role;

            // $input['permissions'] = json_encode($input['permissions']);

            // $role->givePermissionTo($input['permissions']);




        $employe = Employe::create([
            'user_id'                => isset($user) ? $user->id : null,
            'pays_id'                => $request->pays,
            'nom'                    => ucfirst(strtolower($request->nom)),
            'prenoms'                => ucfirst(strtolower($request->prenoms)),
            'telephone'              => str_replace(' ', '', $pays->indicatif.$request->telephone),
            'email'                  => strtolower($request->email),
            'ville'                  => ucfirst(strtolower($request->ville)),
        ]);

        return redirect()->route('employes.index')->with('message', 'Utilisateur créé avec succès.');
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
        $roles = Role::all();
        $permissions = Permission::all();
        $payss = Pays::orderBy('nom', 'asc')->get();
        $employes = Employe::findOrFail($id);

        return view('dashboard.admin.utilisateurs.edit', compact('employes','roles','permissions','payss'));
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
        $request->validate([

        ]);

        $input = $request->all();

        //$validator = Validator::make($request->all());


        $update_employes = Employe::findOrFail($id);

        $update_employes->nom = $request->get('nom');
        $update_employes->prenoms = $request->get('prenoms');
        $update_employes->pays_id = $request->get('pays_id');
        $update_employes->ville = $request->get('ville');
        $update_employes->telephone = $request->get('telephone');

        $update_employes->update();





        return redirect()->route('employes.index')->with('message', 'Utilisateur mis à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $employes = Employe::findOrFail($id);
        $employes->delete();

        return redirect(route('employes.index'))->with('success', 'Plat supprimé avec succès');
    }
}
