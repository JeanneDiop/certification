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




Route::get('/login', function(){
    return response()->json([
        'error' => 'Unauthenticated', 
    ], 401);
})->name('login');
// Tous les users peuvent se connecter 
Route::group(['middleware' => 'api'], function ($router) {
Route::post('logout', [AuthController::class, 'logout']);
// Route::post('refresh', [AuthController::class, 'refresh']);
  
});


Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);


   //lister les employés
Route::get('employe/lister', [AuthController::class, 'index']);
 //afficher un employe
Route::get('employe/detail/{id}', [AuthController::class, 'show']);


Route::middleware(['auth:api','role_proprietaire'])->group(function() { 
//modifier employé
Route::put('employe/edit/{user}', [AuthController::class, 'update']);
//pour achiver employé
 Route::put('employe/archive/{user}', [AuthController::class, 'archiver']);
 });

Route::middleware(['auth:api','role_employe'])->group(function() {  });

Route::put('password/user', [AuthController::class, 'updatepassword']);


//ajouter Categorie
Route::post('categorie/create', [CategorieController::class, 'store']);
//modifier categorie
Route::put('categorie/edit/{id}', [CategorieController::class, 'update']);
//lister les categories
Route::get('categorie/lister', [CategorieController::class, 'index']);
//afficher un categorie
Route::get('categorie/detail/{id}', [CategorieController::class, 'show']);
//supprimer un categorie
Route::delete('categorie/supprimer/{id}', [CategorieController::class, 'destroy']);


//ajouter Produit
Route::post('produit/create', [ProduitController::class, 'store']);
 //modifier un  Produit
Route::put('produit/edit/{id}', [ProduitController::class, 'update']);
  //supprimer un produit
Route::delete('produit/supprimer/{id}', [ProduitController::class, 'destroy']);
   //lister les produits
Route::get('produit/lister', [ProduitController::class, 'index']);
//afficher un produit
Route::get('produit/detail/{id}', [ProduitController::class, 'show']);


//ajouter Tarification
Route::post('tarification/create', [TarificationController::class, 'store']);
//modifier un  Tarification
 Route::put('tarification/edit/{id}', [TarificationController::class, 'update']);
//supprimer un tarification
Route::delete('tarification/supprimer/{id}', [TarificationController::class, 'destroy']);
//lister les tarifications
Route::get('tarification/lister', [TarificationController::class, 'index']);
//afficher un tarification
Route::get('tarification/detail/{id}', [TarificationController::class, 'show']);


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


//ajouter Vente
Route::post('vente/create', [VenteController::class, 'store']);
//modifier  vente
 Route::put('vente/edit/{vente}', [VenteController::class, 'update']);
//lister les ventes
Route::get('vente/lister', [VenteController::class, 'index']);
//afficher vente
Route::get('vente/detail/{id}', [VenteController::class, 'show']);


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


//ajouter payement
Route::post('payement/create', [PayementController::class, 'store']);
//modifier  payement
 Route::put('payement/edit/{id}', [PayementController::class, 'update']);
//supprimer  payement
Route::delete('payement/supprimer/{id}', [PayementController::class, 'destroy']);
//lister les payements
Route::get('payement/lister', [PayementController::class, 'index']);
//afficher payement
Route::get('payement/detail/{id}', [PayementController::class, 'show']);


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

Route::post('whatsapp.userquincaillerie/{id}', [ClientController::class, 'redirigerWhatsApp']);


