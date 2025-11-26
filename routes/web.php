<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\PcGamingController;
use Illuminate\Support\Facades\Route;

// Public routes
Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');

// PC Gaming & Build PC
Route::get('/pc-gaming', [PcGamingController::class, 'index'])->name('pc-gaming.index');
Route::get('/pc-ai', [PcGamingController::class, 'pcAI'])->name('pc-ai.index');
Route::get('/pc-office', [PcGamingController::class, 'pcOffice'])->name('pc-office.index');
Route::get('/pc-design', [PcGamingController::class, 'pcDesign'])->name('pc-design.index');
Route::get('/build-pc', [PcGamingController::class, 'buildPc'])->name('build-pc');

// Cart add - can be accessed by guests (will redirect to login)
Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add')->middleware('auth');

// Auth routes
Route::middleware('auth')->group(function () {
    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Addresses
    Route::resource('addresses', AddressController::class);
    Route::post('/addresses/{address}/set-default', [AddressController::class, 'setDefault'])->name('addresses.set-default');

    // Cart
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::patch('/cart/{cartItem}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/{cartItem}', [CartController::class, 'destroy'])->name('cart.destroy');
    Route::delete('/cart', [CartController::class, 'clear'])->name('cart.clear');

    // Checkout
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::get('/checkout/shipping', [CheckoutController::class, 'shipping'])->name('checkout.shipping');
    Route::post('/checkout/shipping', [CheckoutController::class, 'storeShipping'])->name('checkout.store-shipping');
    Route::get('/checkout/payment', [CheckoutController::class, 'payment'])->name('checkout.payment');
    Route::post('/checkout/payment', [CheckoutController::class, 'storePayment'])->name('checkout.store-payment');
    Route::get('/checkout/review', [CheckoutController::class, 'review'])->name('checkout.review');
    Route::post('/checkout/place-order', [CheckoutController::class, 'placeOrder'])->name('checkout.place-order');

    // Orders
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::post('/orders/{order}/reorder', [OrderController::class, 'reorder'])->name('orders.reorder');
    Route::post('/orders/{order}/cancel', [OrderController::class, 'cancel'])->name('orders.cancel');

    // Reviews
    Route::post('/products/{product}/reviews', [ReviewController::class, 'store'])->name('reviews.store');
    Route::patch('/reviews/{review}', [ReviewController::class, 'update'])->name('reviews.update');
    Route::delete('/reviews/{review}', [ReviewController::class, 'destroy'])->name('reviews.destroy');

    // Dashboard (optional)
    Route::get('/dashboard', function () {
        return redirect()->route('orders.index');
    })->name('dashboard');
});

// Admin routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
    
    // Products
    Route::resource('products', \App\Http\Controllers\Admin\ProductController::class);
    Route::get('/products/specs/by-component-type', [\App\Http\Controllers\Admin\ProductController::class, 'getSpecDefinitions'])->name('products.specs.by-component-type');
    
    // Spec Definitions
    Route::resource('spec-definitions', \App\Http\Controllers\Admin\SpecDefinitionController::class);
    
    // Orders
    Route::get('/orders', [\App\Http\Controllers\Admin\OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [\App\Http\Controllers\Admin\OrderController::class, 'show'])->name('orders.show');
    Route::post('/orders/{order}/status', [\App\Http\Controllers\Admin\OrderController::class, 'updateStatus'])->name('orders.update-status');

    // Users management
    Route::resource('users', \App\Http\Controllers\Admin\UserController::class)->only(['index','show','edit','update','destroy']);
    Route::post('/users/{user}/verify', [\App\Http\Controllers\Admin\UserController::class, 'markVerified'])->name('users.verify');

    
});

Route::get('/logout', function () {
    Auth::logout();
    Session()->invalidate();
    Session()->regenerateToken();
    return redirect('/login');
});

require __DIR__.'/auth.php';
