<?php

namespace App\Http\Controllers;

use App\Models\Admin;
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
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;


class AdminController extends Controller
{

    public function index() {

        return view('dashboard.admin.statistiques');

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

        return redirect()->route('dashboard.admin.utilisateurs.index')->with('message', "Le gestionnaire de compte peut maintenant effectuer des opérations de distributeur.");
    }


}
