<?php

use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;

use App\Http\Controllers\RetraitController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TransfertController;
use App\Http\Controllers\API\ClientController;
use App\Http\Controllers\IndexAdminController;
use App\Http\Controllers\CarteCreditController;

use App\Http\Controllers\UtilisateurController;
use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\CompteBancaireController;

use App\Http\Controllers\RoleAdminController;
use App\Http\Controllers\PermissionAdminController;
use App\Http\Controllers\UserAdminController;


use App\Http\Controllers\UserPaymentMethodController;
use App\Http\Controllers\UserPaymentAccountController;

<<<<<<< HEAD
// use App\Http\Controllers\Admin\RoleAdminController;
// use App\Http\Controllers\Admin\UserAdminController;
// use App\Http\Controllers\Admin\IndexAdminController;
// use App\Http\Controllers\Admin\PermissionAdminController;

=======
use App\Http\Controllers\Auth\EmailVerificationPromptController;
>>>>>>> 100515abad76e3486098d332b5592d2b39ff6738

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
<<<<<<< HEAD
 */

//  Route::group(['middleware' => ['auth','verified',]], function() {
//     Route::resource('dashboard', DashboardController::class);
//     Route::resource('roles', RoleController::class);
//     Route::resource('utilisateurs', UtilisateurController::class);
//     Route::apiResource('clients',ClientController::class);
//     Route::Resource('credit_card',CarteCreditController::class);
//     Route::resource('compte_banque', CompteBancaireController::class);

// });

Route::middleware(['auth', 'role:admin'])->name('admin.')->prefix('admin')->group(function () {
     Route::get('/', [IndexAdminController::class, 'index'])->name('index');
    Route::resource('/roles', RoleAdminController::class);
    Route::post('/roles/{role}/permissions', [RoleAdminController::class, 'givePermission'])->name('roles.permissions');
    Route::delete('/roles/{role}/permissions/{permission}', [RoleAdminController::class, 'revokePermission'])->name('roles.permissions.revoke');
    Route::resource('/permissions', PermissionAdminController::class);
    Route::post('/permissions/{permission}/roles', [PermissionAdminController::class, 'assignRole'])->name('permissions.roles');
    Route::delete('/permissions/{permission}/roles/{role}', [PermissionAdminController::class, 'removeRole'])->name('permissions.roles.remove');
    Route::get('/users', [UserAdminController::class, 'index'])->name('users.index');
    Route::get('/users/{user}', [UserAdminController::class, 'show'])->name('users.show');
    Route::delete('/users/{user}', [UserAdminController::class, 'destroy'])->name('users.destroy');
    Route::post('/users/{user}/roles', [UserAdminController::class, 'assignRole'])->name('users.roles');
    Route::delete('/users/{user}/roles/{role}', [UserAdminController::class, 'removeRole'])->name('users.roles.remove');
    Route::post('/users/{user}/permissions', [UserAdminController::class, 'givePermission'])->name('users.permissions');
    Route::delete('/users/{user}/permissions/{permission}', [UserAdminController::class, 'revokePermission'])->name('users.permissions.revoke');
});



=======
 */ 
>>>>>>> 100515abad76e3486098d332b5592d2b39ff6738



if (env('APP_ENV') == 'production') {
    URL::forceScheme('https');
}




Route::get('/', [WelcomeController::class, 'index']);
Route::get('/contact', [WelcomeController::class, 'contact'])->name('contact');
Route::get('/about', [WelcomeController::class, 'about'])->name('about');
Route::get('/signup', [WelcomeController::class, 'signup'])->name('signup');
Route::post('/signup', [AuthenticationController::class, 'register']);
Route::get('/login', [WelcomeController::class, 'login'])->name('login');
Route::post('/login', [AuthenticationController::class, 'login']);
Route::post('/logout', [AuthenticationController::class, 'logout'])->name('logout');
Route::get('/validateSms', [AuthenticationController::class, 'showSmsValidationForm'])->name('validateSmsCodeForm');


//Official for code validation
Route::match(["get", "post"], "/validation/code", [AuthenticationController::class, "validateCode"]);
Route::post("/resendemailcode", [AuthenticationController::class, "resendEmailCode"]);
Route::post("/resendsmscode", [AuthenticationController::class, "resendSmsCode"]);
//

//
Route::get('/api/validation/{codeDetails}', [AuthenticationController::class, 'validateCode']);

//Route::get('/api/validation', [AuthenticationController::class, 'validateCode']);

Route::middleware(['auth', 'ip.valid'])->group(function () {

        Route::get('/home', [HomeController::class, 'index'])->name('home');

        Route::get('/transactions', [HomeController::class, 'transactions'])->name('transactions');

        //send
        Route::get('/send', [HomeController::class, 'send'])->name('send');
        Route::get('/send-confirm', [HomeController::class, 'sendConfirm'])->name('sendConfirm');
        Route::get('/send-status', [HomeController::class, 'sendStatus'])->name('sendStatus');

        //deposit
        Route::get('/deposit', [HomeController::class, 'deposit'])->name('deposit');

        //retrait
        Route::get('/retrait', [HomeController::class, 'retrait'])->name('retrait');

        //withdraw
        Route::post('withdrawal', [RetraitController::class, 'withdrawal'])->name('makeWithdraw');

        //profil
        Route::get('/profil', [UserController::class, 'profile'])->name('profile');
        Route::get('/cardsAndAccounts', [UserController::class, 'cardsAndAccounts'])->name('cardsAndAccounts');

        //ADD PAYMENT CARDS
        Route::post('/addCard', [UserPaymentMethodController::class, 'addPaymentCard'])->name('addPaymentCard');
        Route::post('/deletePayMeth', [UserPaymentMethodController::class, 'deletePaymentMethod'])->name('deletePaymentMethod');

        //ADD BANK ACCOUNT NUMBER
        Route::post('/addBankAccount', [UserPaymentAccountController::class, 'addBankAccount'])->name('addBankAccount');
        Route::post('/deleteBankAccount', [UserPaymentAccountController::class, 'deleteBankAccount'])->name('deleteBankAccount');

        //UPDATE PASSWORD
        Route::post('/updatePassword', [UserController::class, 'updatePassword'])->name('updatePassword');

        //when updating from app
        Route::get('/resetPassword/{cryptedEmail}', [AuthenticationController::class, 'showResetPasswordForm']);
        Route::post('/resetPassword', [AuthenticationController::class, 'resetPassword'])->name("resetPassword");

        //TRANSFERTS
        Route::post('/transferts', [TransfertController::class, 'send'])->name('transferts');

        // ----------------------------------------
        /**
         * * Route concernant les clients
         */

        Route::middleware(['can:is-client'])->prefix('client')->name('client.')->group(function () {
            // Route::get('paiement-commercant', [PaiementCommercantController::class, 'formPaiement'])->name('paiement-commercant.form-paiement');
            // Route::prefix('transfert')->name('transfert.')->group(function () {
            //     Route::get('/', [TransfertController::class, 'index'])->name('index');

            //     Route::get('nouveau', [TransfertController::class, 'create'])->name('create');

            //     Route::post('transferer', [TransfertController::class, 'store'])->name('store');
            // });

            Route::prefix('rechargement')->name('rechargement.')->group(function () {
                Route::get('/', [RechargementController::class, 'index'])->name('index');
                Route::get('{moyenRechargement}', [RechargementController::class, 'create'])->name('create');
                Route::post('store/{moyenRechargement}', [RechargementController::class, 'store'])->name('store');
            });

            // Route::prefix('retrait')->name('retrait.')->group(function () {
                // Route::get('/', [RetraitController::class, 'index'])->name('index');
                // Route::get('create', [RetraitController::class, 'create'])->name('create');
            // });



            /* * Pour les paiements
            Route::prefix('paiement')->name('paiement.')->group(function () {
            Route::get('/', function () {
            return view('client.paiement.index');
            })->name('index');

            Route::get('{paiement}', function ($paiement) {
            if ($paiement == 'canal-plus') {
            $data = [
            'title' => 'Canal plus',
            'img' => asset('images/marchands/canal-plus.png'),
            ];
            } elseif ($paiement == 'startimes') {
            $data = [
            'title' => 'StarTimes',
            'img' => asset('images/marchands/startimes.png'),
            ];
            } else {
            }

            return view('client.paiement.create', compact('paiement', 'data'));
            })->name('create');
            }); */
        });

       
});


// ROUTES ADMIN 


Route::prefix('dashboard')->middleware(['auth', 'ip.valid',])->group(function() {

    Route::get('/', [AdminController::class, 'statistiques'])->name('dashboard');

    Route::get('/liste_clients', [AdminController::class, 'liste_clients'])->name('liste_clients');
    Route::get('/details_client/{id}', [AdminController::class, 'details_client'])->name('details_client');

    Route::get('/liste_employes', [AdminController::class, 'liste_employes'])->name('liste_employes')->middleware(['role:admin']);
    Route::get('/ajout_employe', [AdminController::class, 'ajout_employe'])->name('ajout_employe')->middleware(['role:admin']);
    Route::put('/modification_employe/{id}', [AdminController::class, 'modification_employe'])->name('modification_employe')->middleware(['role:admin']);
    Route::get('/suppression_employe/{id}', [AdminController::class, 'suppression_employe'])->name('suppression_employe')->middleware(['role:admin']);


    Route::get('/liste_marchands', [AdminController::class, 'liste_marchands'])->name('liste_marchands')->middleware(['role:admin']);
    Route::get('/liste_distributeurs', [AdminController::class, 'liste_distributeurs'])->name('liste_distributeurs')->middleware(['role:admin']);


    // Route::resource('dashboard', DashboardController::class);
    // Route::resource('roles', RoleController::class);
    // Route::resource('utilisateurs', UtilisateurController::class);
    // Route::apiResource('clients',ClientController::class);
    // Route::Resource('credit_card',CarteCreditController::class);
    // Route::resource('compte_banque', CompteBancaireController::class);


});


