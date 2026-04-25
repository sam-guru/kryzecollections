<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\CartController;



Route::get('/', [ProductController::class, 'index']);

Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add');
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::get('/product/{product}', [ProductController::class, 'show']);

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

//log in routes
Route::middleware('auth', 'admin')->group(function () {
     Route::post('/favorite/{product}', [FavoriteController::class, 'toggle'])
        ->name('favorite.toggle');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/dashboard', function () { 
            return view('dashboard');
        })->name('dashboard');
    
    Route::resource('admin/products', AdminProductController::class);

});

// Route::middleware(['auth', 'admin'])->group(function () {
// });

require __DIR__.'/auth.php';
