<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
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
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{product:slug}', [ProductController::class, 'show'])->name('products.show');

// Các route yêu cầu đăng nhập
Route::middleware(['auth'])->group(function () {
    // Giỏ hàng
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
    Route::patch('/cart/update', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');

    // (tùy chọn) Checkout giả lập, hồ sơ, lịch sử đơn hàng
    // Route::get('/checkout', ...)->name('checkout.index');
});

// Khu vực Admin
Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth', 'admin'])
    ->group(function () {
        Route::view('/', 'admin.dashboard')->name('dashboard');

        // Resource CRUD cho sản phẩm (Admin)
        Route::resource('products', AdminProductController::class);
    });

// Breeze routes (nếu dùng): require __DIR__.'/auth.php';
