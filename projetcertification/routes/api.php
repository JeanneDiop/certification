<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AchatController;
use App\Http\Controllers\API\VenteController;
use App\Http\Controllers\API\ClientController;
use App\Http\Controllers\API\FactureController;
use App\Http\Controllers\API\ProduitController;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\PayementController;
use App\Http\Controllers\API\CategorieController;
use App\Http\Controllers\TarificationController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
   // return $request->user();
//});




// Route::get('/login', function(){
//     return response()->json([
//         'error' => 'Unauthenticated', 
//     ], 401);
// })->name('login');
// Tous les users peuvent se connecter 
Route::group(['middleware' => 'api'], function ($router) {
Route::post('logout', [AuthController::class, 'logout']);
// Route::post('refresh', [AuthController::class, 'refresh']);
  
});


Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);










//MIDLEWARE ou tout utilisateur connecté pourra avoir l'accés

Route::middleware(['auth:api'])->group(function () {
//ajouter Produit
Route::post('produit/create', [ProduitController::class, 'store']);
//modifier un  Produit
Route::put('produit/edit/{id}', [ProduitController::class, 'update']);
 //supprimer un produit
Route::delete('produit/supprimer/{id}', [ProduitController::class, 'destroy']);
//voir les produits par categorie
Route::get('produit/{categorie_id}', [ProduitController::class, 'getProduitsByCategorie']);

//ajouter Vente
Route::post('vente/create', [VenteController::class, 'store']);
//modifier  vente
 Route::put('vente/edit/{vente}', [VenteController::class, 'update']);
//lister les ventes
Route::get('vente/lister', [VenteController::class, 'index']);
//afficher vente
Route::get('vente/detail/{id}', [VenteController::class, 'show']);
//supprimer  vente
Route::delete('vente/supprimer/{id}', [VenteController::class, 'destroy']);



//ajouter Client
Route::post('client/create', [ClientController::class, 'store']);
//modifier  client
 Route::put('client/edit/{id}', [ClientController::class, 'update']);
//supprimer  client
Route::delete('client/supprimer/{id}', [ClientController::class, 'destroy']);
//lister les cients
Route::get('client/lister', [ClientController::class, 'index']);
//afficher client
Route::get('client/detail/{id}', [ClientController::class, 'show']);

//ajouter facture
Route::post('facture/create', [FactureController::class, 'store']);
//modifier  facture
 Route::put('facture/edit/{id}', [FactureController::class, 'update']);
//supprimer  facture
Route::delete('facture/supprimer/{id}', [FactureController::class, 'destroy']);
//lister les factures
Route::get('facture/lister', [FactureController::class, 'index']);
//afficher facture
Route::get('facture/detail/{id}', [FactureController::class, 'show']);


//ajouter payement
Route::post('payement/create', [PayementController::class, 'store']);
//modifier  payement
 Route::put('payement/edit/{payement}', [PayementController::class, 'update']);
//supprimer  payement
Route::delete('payement/supprimer/{payement}', [PayementController::class, 'destroy']);
 //lister les payements
 Route::get('payement/lister', [PayementController::class, 'index']);
 //afficher payement
 Route::get('payement/detail/{payement}', [PayementController::class, 'show']);

 //ajouter Categorie
 Route::post('categorie/create', [CategorieController::class, 'store']);
 //modifier categorie
 Route::put('categorie/edit/{id}', [CategorieController::class, 'update']);
 //supprimer un categorie
 Route::delete('categorie/supprimer/{id}', [CategorieController::class, 'destroy']);
 //lister les categories
Route::get('categorie/lister', [CategorieController::class, 'index']);
//afficher un categorie
Route::get('categorie/detail/{id}', [CategorieController::class, 'show']);
 

 //ajouter Achat
 Route::post('achat/create', [AchatController::class, 'store']);
 //modifier  achat
  Route::put('achat/edit/{achat}', [AchatController::class, 'update']);
 //supprimer  achat
 Route::delete('achat/supprimer/{achat}', [AchatController::class, 'destroy']);
 //lister les achats
 Route::get('achat/lister', [AchatController::class, 'index']);
 //afficher achat
 Route::get('achat/detail/{id}', [AchatController::class, 'show']);

});

//MIDLEWARE PROPRIETAIRE

Route::middleware(['auth:api','role_proprietaire'])->group(function() { 

//modifier employé
Route::put('employe/edit/{user}', [AuthController::class, 'update']);
//pour achiver employé
 Route::put('employe/archive/{user}', [AuthController::class, 'archiver']);

//lister les employés
Route::get('employe/lister', [AuthController::class, 'index']);
//afficher un employe
Route::get('employe/detail/{id}', [AuthController::class, 'show']);


 });



//MIDLEWARE EMPLOYE
Route::middleware(['auth:api','role_employe'])->group(function() {  });

Route::post('passworde/{id}', [AuthController::class, 'updatepassword']);


   //lister les produits
Route::get('produits/lister', [ProduitController::class, 'index']);
//afficher un produit
Route::get('produit/detail/{id}', [ProduitController::class, 'show']);


Route::post('whatsapp.userquincaillerie/{id}', [ClientController::class, 'redirigerWhatsApp']);


// Route::get('reset-password/{token}', [ForgotPasswordController::class, 'showResetPasswordForm'])->name('reset.password.get');
// Route::post('reset-password', [ForgotPasswordController::class, 'submitResetPasswordForm'])->name('reset.password.post');
// Route::post('forget-password', [ForgotPasswordController::class, 'submitForgetPasswordForm'])->name('forget.password.post');


