<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SellerController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\Auth\FacebookController;
use App\Models\Item;
use App\Models\Category;
use App\Models\Game;

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

Route::get('/clear-cache', function () {
    Artisan::call('config:clear');
    Artisan::call('cache:clear');
    Artisan::call('config:cache');
    return "Config and cache cleared!";
});

Route::middleware('verified')->group(function () {
    Route::get('/', function () {
        $categories = Category::with('games')->get();
        return view('frontend.home', compact('categories'));
    });
    Route::get('/seller-verification', function () {
        return view('frontend.seller_verification');
    });
    Route::post('/seller-verification', [SellerController::class, 'verification'])->name('seller.verify');

    // Get Data for Item
    Route::get('/get-games', [ItemController::class, 'getGames']);
    Route::get('/get-attributes', [ItemController::class, 'getAttributes']);

    // Item Routes
    Route::get('/items/create', [ItemController::class, 'create'])->name('items.create');
    Route::post('/items/store', [ItemController::class, 'store'])->name('items.store');

    Route::get('catalog/{category_id}/{game_id}', [GameController::class, 'index']);
});

Route::get('auth/google', [GoogleController::class, 'redirectToGoogle']);
Route::get('auth/google/callback', [GoogleController::class, 'handleGoogleCallback']);

Route::get('auth/facebook', [FacebookController::class, 'redirectToFacebook']);
Route::get('auth/facebook/callback', [FacebookController::class, 'handleFacebookCallback']);

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
