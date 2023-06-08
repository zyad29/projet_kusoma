<?php

use App\Http\Controllers\ProfileController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


use App\Http\Controllers\ClientController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PdfController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SliderController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [ClientController::class, 'home']);
Route::get('/shop', [ClientController::class, 'shop']);
Route::get('/panier', [ClientController::class, 'panier']);
Route::get('/client_login', [ClientController::class, 'client_login']);
Route::get('/connexion', [ClientController::class, 'connexion']);
Route::get('/inscription', [ClientController::class, 'inscription']);
Route::get('/connexion', [ClientController::class, 'connexion']);

Route::get('/signup', [ClientController::class, 'signup']);
Route::get('/paiement', [ClientController::class, 'paiement']);
Route::get('select_par_cat/{name}', [ClientController::class, 'select_par_cat']);
Route::get('/ajouter_au_panier/{id}', [ClientController::class, 'ajouter_au_panier']);
Route::post('/modifier_qty/{id}', [ClientController::class, 'modifier_panier']);
Route::get('/retirer_produit/{id}', [ClientController::class, 'retirer_produit']);
Route::post('/payer', [ClientController::class, 'payer']);
Route::post('/creer_compte', [ClientController::class, 'creer_compte']);
Route::post('/acceder_compte', [ClientController::class, 'acceder_compte']);
Route::get('/logout', [ClientController::class, 'logout']);



Route::get('/voir_pdf/{id}', [PdfController::class, 'voir_pdf']);


Route::get('/admin', [AdminController::class, 'dashboard']);
Route::get('/commandes', [AdminController::class, 'commandes']);
Route::get('/ajoutercategorie', [CategoryController::class, 'ajoutercategorie']);
Route::post('sauvercategorie', [CategoryController::class, 'sauvercategorie']);
Route::get('/edit_categorie/{id}', [CategoryController::class, 'edit_categorie']);
Route::post('/modifiercategorie', [CategoryController::class, 'modifiercategorie']);
Route::get('/supprimercategorie/{id}', [CategoryController::class, 'supprimercategorie']);
Route::get('/ajouterproduit', [ProductController::class, 'ajouterproduit']);
Route::post('/sauverproduit', [ProductController::class, 'sauverproduit']);
Route::get('/produits', [ProductController::class, 'produits']);
Route::get('/edit_produit/{id}', [ProductController::class, 'edit_produit']);
Route::post('/modifierproduit', [ProductController::class, 'modifierproduit']);
Route::get('/supprimerproduit/{id}', [ProductController::class, 'supprimerproduit']);
Route::get('/activer_produit/{id}', [ProductController::class, 'activer_produit']);
Route::get('/desactiver_produit/{id}', [ProductController::class, 'desactiver_produit']);
Route::get('/sliders', [SliderController::class, 'sliders']);
Route::get('/ajouterslider', [SliderController::class, 'ajouterslider']);
Route::post('/sauverslider', [SliderController::class, 'sauverslider']);
Route::get('/edit_slider/{id}', [SliderController::class, 'editslider']);
Route::post('/modifierslider', [SliderController::class, 'modifierslider']);
Route::get('/supprimerslider/{id}', [SliderController::class, 'supprimerslider']);
Route::get('/desactiver_slider/{id}', [SliderController::class, 'desactiver_slider']);
Route::get('/activer_slider/{id}', [SliderController::class, 'activer_slider']);
Route::get('/categories', [CategoryController::class, 'categories']);



Route::get('/admin', [HomeController::class, 'index']);








Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
