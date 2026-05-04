<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\AddressController;


//  PUBLIC ROUTES
Route::get('/', [ProductController::class, 'index'])->name('home');

Route::get('/product/{product}', [ProductController::class, 'show'])
    ->name('products.show');

Route::post('/cart/add/{product}', [CartController::class, 'add'])
    ->name('cart.add');

Route::get('/cart', [CartController::class, 'index'])
    ->name('cart.index');

Route::delete('/cart/remove/{id}', [CartController::class, 'remove'])
    ->name('cart.remove');

Route::delete('/cart/clear', [CartController::class, 'clear'])
    ->name('cart.clear');

Route::get('/clear-cart', function () {
    session()->forget('cart');
    return redirect('/');
});

Route::get('/checkout-complete', [CheckoutController::class, 'complete'])->name('checkout.success');




//  USER ROUTES
Route::middleware('auth')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::post('/favorite/{product}', [FavoriteController::class, 'toggle'])
        ->name('favorite.toggle');

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');
    
    // Shipping Address Routes
    Route::post('/addresses', [AddressController::class, 'store'])
        ->name('addresses.store');
    Route::delete('/addresses/{address}', [AddressController::class, 'destroy'])
        ->name('addresses.destroy');

    // Checkout Routes
    // Start Checkout
    Route::get('/checkout/address', [CheckoutController::class, 'selectAddress'])
        ->name('checkout.address');
    
    // Process Address Selection -> Show Review
    Route::post('/checkout/review', [CheckoutController::class, 'reviewOrder'])
        ->name('checkout.review');
    
    // Final Step (The Simulation)
    Route::post('/checkout/complete', [CheckoutController::class, 'complete'])
        ->name('checkout.store');
    
    // The Success Page
    Route::get('/checkout-complete', function() {
        return view('checkout-success');
    })->name('checkout.success');
});




// ADMIN ROUTES
Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/dashboard', function () {
            return view('admin.dashboard');
        })->name('dashboard');

        Route::resource('products', AdminProductController::class);
    });


require __DIR__.'/auth.php';