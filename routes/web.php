<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
| - Nhóm route public (trang chủ, blog, sản phẩm)
| - Nhóm route yêu cầu đăng nhập (giỏ hàng, hồ sơ)
| - Nhóm route quản trị (prefix 'admin', middleware 'admin')
*/

// Trang công khai
Route::view('/', 'welcome')->name('home');
Route::view('/about', 'about')->name('about');
Route::view('/contact', 'contact')->name('contact');
Route::view('/blog', 'blog.index')->name('blog.index');

// Sản phẩm (user-facing)
Route::prefix('products')
    ->name('products.')
    ->group(function () {
        Route::get('/', [ProductController::class, 'index'])->name('index');
        Route::get('/search', [ProductController::class, 'search'])->name('search');
        Route::get('/{product:slug}', [ProductController::class, 'show'])->name('show');
    });

// Các route yêu cầu đăng nhập
Route::middleware(['auth', 'verified'])->group(function () {
    // Giỏ hàng
    Route::prefix('cart')
        ->name('cart.')
        ->group(function () {
            Route::get('/', [CartController::class, 'index'])->name('index');
            Route::post('/add', [CartController::class, 'add'])->name('add');
            Route::patch('/update', [CartController::class, 'update'])->name('update');
            Route::delete('/remove', [CartController::class, 'remove'])->name('remove');
            Route::post('/clear', [CartController::class, 'clear'])->name('clear');
        });

    // Checkout
    Route::prefix('checkout')
        ->name('checkout.')
        ->group(function () {
            Route::get('/', [CheckoutController::class, 'show'])->name('show');
            Route::post('/', [CheckoutController::class, 'store'])->name('store');
        });

    // Đơn hàng
    Route::prefix('orders')
        ->name('orders.')
        ->group(function () {
            Route::get('/', [OrderController::class, 'index'])->name('index');
            Route::get('/{order}', [OrderController::class, 'show'])->name('show');
            Route::post('/{order}/cancel', [OrderController::class, 'cancel'])->name('cancel');
        });
});

// Khu vực Admin
Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth', 'verified', 'admin'])
    ->group(function () {
        // Dashboard
        Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');

        // Sản phẩm
        Route::resource('products', AdminProductController::class);

        // Đơn hàng
        Route::resource('orders', AdminOrderController::class, ['only' => ['index', 'show', 'update']]);
    });

// Breeze auth routes
require __DIR__.'/auth.php';

