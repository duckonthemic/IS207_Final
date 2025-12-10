<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\PcGamingController;
use App\Http\Controllers\NewsletterController;
use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Route;

// Public routes
Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/compare', [ProductController::class, 'compare'])->name('products.compare');
Route::get('/api/search/suggestions', [ProductController::class, 'searchSuggestions'])->name('search.suggestions');
Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');
Route::get('/api/products/{product}', [ProductController::class, 'getJson'])->name('products.json');

// PC Gaming & Build PC
Route::get('/pc-gaming', [PcGamingController::class, 'index'])->name('pc-gaming.index');
Route::get('/pc-ai', [PcGamingController::class, 'pcAI'])->name('pc-ai.index');
Route::get('/pc-office', [PcGamingController::class, 'pcOffice'])->name('pc-office.index');
Route::get('/pc-design', [PcGamingController::class, 'pcDesign'])->name('pc-design.index');
Route::get('/build-pc', [PcGamingController::class, 'buildPc'])->name('build-pc');

// Newsletter
Route::post('/newsletter/subscribe', [NewsletterController::class, 'subscribe'])->name('newsletter.subscribe');

// Static Pages
Route::get('/terms', function () {
    return view('pages.terms');
})->name('terms');
Route::get('/privacy', function () {
    return view('pages.privacy');
})->name('privacy');
Route::get('/page/{slug}', [PageController::class, 'show'])->name('page.show');

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
    Route::post('/checkout/apply-coupon', [CheckoutController::class, 'applyCoupon'])->name('checkout.apply-coupon');
    Route::post('/checkout/remove-coupon', [CheckoutController::class, 'removeCoupon'])->name('checkout.remove-coupon');
    Route::get('/checkout/shipping-methods', [CheckoutController::class, 'getShippingMethodsApi'])->name('checkout.shipping-methods');
    Route::post('/checkout/update-shipping', [CheckoutController::class, 'updateShipping'])->name('checkout.update-shipping');
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

    // Categories
    Route::resource('categories', \App\Http\Controllers\Admin\CategoryController::class);

    // Spec Definitions
    Route::resource('spec-definitions', \App\Http\Controllers\Admin\SpecDefinitionController::class);

    // Orders
    Route::get('/orders', [\App\Http\Controllers\Admin\OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [\App\Http\Controllers\Admin\OrderController::class, 'show'])->name('orders.show');
    Route::patch('/orders/{order}', [\App\Http\Controllers\Admin\OrderController::class, 'update'])->name('orders.update');
    Route::post('/orders/{order}/status', [\App\Http\Controllers\Admin\OrderController::class, 'updateStatus'])->name('orders.update-status');

    // Reviews
    Route::get('/reviews', [\App\Http\Controllers\Admin\ReviewController::class, 'index'])->name('reviews.index');
    Route::patch('/reviews/{review}/status', [\App\Http\Controllers\Admin\ReviewController::class, 'updateStatus'])->name('reviews.update-status');
    Route::delete('/reviews/{review}', [\App\Http\Controllers\Admin\ReviewController::class, 'destroy'])->name('reviews.destroy');

    // Promotions
    Route::resource('promotions', \App\Http\Controllers\Admin\PromotionController::class);
    Route::post('/promotions/{promotion}/toggle-status', [\App\Http\Controllers\Admin\PromotionController::class, 'toggleStatus'])->name('promotions.toggle-status');
});

Route::get('/logout', function () {
    Auth::logout();
    Session()->invalidate();
    Session()->regenerateToken();
    return redirect('/login');
});

require __DIR__ . '/auth.php';

