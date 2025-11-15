# CẤU TRÚC DỰ ÁN CHI TIẾT

> 📖 **Tài liệu này:** Giải thích cấu trúc dự án Laravel để người mới có thể hiểu rõ từng folder/file làm gì

---

## 🗂️ CẤU TRÚC TỔNG QUAN

```
IS207_Final/
├── app/              # Backend PHP code (Models, Controllers, Logic)
├── bootstrap/        # Khởi tạo ứng dụng Laravel
├── config/           # File cấu hình (database, mail, cache...)
├── database/         # Migrations, Seeders, Factories
├── public/           # Entry point, static files (CSS, JS, images)
├── resources/        # Views (Blade templates), CSS, JS source
├── routes/           # Định nghĩa URL routes
├── storage/          # Logs, cache, uploaded files
├── tests/            # Unit & Feature tests
└── vendor/           # Composer dependencies (do NOT edit)
```

---

## 📂 CHI TIẾT TỪNG FOLDER

### 1️⃣ `app/` - Backend Logic (PHP)

```
app/
├── Console/          # Artisan commands tùy chỉnh
│   └── Kernel.php    # Đăng ký scheduled tasks
│
├── Exceptions/       # Exception handling
│   └── Handler.php   # Xử lý lỗi toàn cục
│
├── Http/
│   ├── Controllers/  # ⭐ CONTROLLERS - Xử lý logic nghiệp vụ
│   │   ├── ProductController.php       # Hiển thị sản phẩm cho user
│   │   ├── CartController.php          # Quản lý giỏ hàng
│   │   ├── CheckoutController.php      # Thanh toán (3 bước)
│   │   ├── OrderController.php         # Lịch sử đơn hàng
│   │   ├── AddressController.php       # CRUD địa chỉ giao hàng
│   │   ├── ReviewController.php        # Đánh giá sản phẩm
│   │   ├── PcGamingController.php      # Build PC & pre-built
│   │   └── Admin/
│   │       ├── DashboardController.php # Admin dashboard
│   │       ├── ProductController.php   # Admin CRUD sản phẩm
│   │       └── OrderController.php     # Admin quản lý đơn
│   │
│   ├── Middleware/   # ⭐ MIDDLEWARE - Kiểm tra trước khi vào controller
│   │   ├── Authenticate.php            # Kiểm tra đăng nhập
│   │   ├── AdminMiddleware.php         # Kiểm tra quyền admin
│   │   └── VerifyCsrfToken.php         # Bảo mật CSRF
│   │
│   ├── Requests/     # Form validation rules
│   │   ├── StoreProductRequest.php
│   │   └── ProfileUpdateRequest.php
│   │
│   └── Kernel.php    # Đăng ký middleware, routes
│
├── Models/           # ⭐ ELOQUENT MODELS - Tương tác với database
│   ├── User.php                  # Người dùng (admin/customer)
│   ├── Product.php               # Sản phẩm
│   ├── Category.php              # Danh mục (CPU, GPU, RAM...)
│   ├── Brand.php                 # Thương hiệu (Intel, AMD, NVIDIA...)
│   ├── ComponentType.php         # Loại linh kiện
│   ├── Cart.php                  # Giỏ hàng
│   ├── CartItem.php              # Chi tiết giỏ hàng
│   ├── Order.php                 # Đơn hàng
│   ├── OrderItem.php             # Chi tiết đơn hàng
│   ├── ProductImage.php          # Hình ảnh sản phẩm (1 product nhiều images)
│   ├── ProductSpec.php           # Thông số kỹ thuật sản phẩm
│   ├── SpecDefinition.php        # Định nghĩa specs (Clock Speed, Cores...)
│   ├── UserAddress.php           # Địa chỉ giao hàng
│   ├── ProductReview.php         # Đánh giá sản phẩm
│   └── BuildConfig.php           # Build PC đã lưu
│
└── Providers/        # Service providers
    ├── AppServiceProvider.php
    └── RouteServiceProvider.php
```

**💡 Giải thích:**
- **Controllers:** Nhận request → Xử lý logic → Trả về view hoặc JSON
- **Models:** Đại diện cho 1 bảng trong database, có methods để query
- **Middleware:** "Gác cổng" kiểm tra user trước khi vào controller

---

### 2️⃣ `database/` - Database Structure & Data

```
database/
├── migrations/       # ⭐ MIGRATIONS - Cấu trúc database (schema)
│   ├── 2025_11_01_000001_create_categories_table.php
│   ├── 2025_11_01_000002_create_products_table.php
│   ├── 2025_11_14_111106_create_spec_definitions_table.php
│   └── ... (25+ files)
│
├── seeders/          # ⭐ SEEDERS - Dữ liệu mẫu
│   ├── DatabaseSeeder.php          # Master seeder (gọi tất cả)
│   ├── AdminUserSeeder.php         # Tạo admin user
│   ├── CategorySeeder.php          # 10 categories
│   ├── ComponentTypeSeeder.php     # 7 component types
│   ├── HardwareProductSeeder.php   # 262 products
│   ├── ProductImageSeeder.php      # 1000+ images
│   ├── SpecDefinitionSeeder.php    # 50+ spec definitions
│   └── ProductSpecSeeder.php       # 1500+ product specs
│
└── factories/        # Model factories cho testing
    ├── ProductFactory.php
    └── OrderFactory.php
```

**💡 Cách chạy:**
```powershell
# Chạy migrations (tạo tables)
php artisan migrate

# Chạy seeders (thêm dữ liệu mẫu)
php artisan db:seed

# Reset database + seed lại
php artisan migrate:fresh --seed
```

**📊 Dữ liệu đã seed:**
- 262 products (CPU: 42, GPU: 44, RAM: 28, SSD: 40...)
- 10 categories
- 18 brands
- 1000+ product images
- 1500+ product specifications

---

### 3️⃣ `resources/` - Frontend Assets

```
resources/
├── css/
│   └── app.css       # ⭐ Tailwind CSS configuration
│
├── js/
│   ├── app.js        # ⭐ Main JavaScript (Alpine.js)
│   └── bootstrap.js  # Bootstrap libraries (Axios)
│
└── views/            # ⭐ BLADE TEMPLATES - HTML with PHP logic
    ├── layouts/
    │   ├── app.blade.php       # Master layout (user)
    │   ├── admin.blade.php     # Master layout (admin)
    │   └── guest.blade.php     # Layout cho guest
    │
    ├── partials/
    │   ├── header.blade.php    # Header (logo, menu, search)
    │   └── footer.blade.php    # Footer (links, copyright)
    │
    ├── products/
    │   ├── index.blade.php     # Danh sách sản phẩm
    │   └── show.blade.php      # Chi tiết sản phẩm
    │
    ├── cart/
    │   └── index.blade.php     # Giỏ hàng
    │
    ├── checkout/
    │   ├── shipping.blade.php  # Bước 1: Địa chỉ giao hàng
    │   ├── payment.blade.php   # Bước 2: Phương thức thanh toán
    │   └── review.blade.php    # Bước 3: Xác nhận đơn hàng
    │
    ├── orders/
    │   ├── index.blade.php     # Lịch sử đơn hàng
    │   └── show.blade.php      # Chi tiết đơn hàng
    │
    ├── admin/
    │   ├── dashboard.blade.php     # Admin dashboard
    │   ├── products/
    │   │   ├── index.blade.php     # Danh sách sản phẩm
    │   │   ├── create.blade.php    # Tạo sản phẩm mới
    │   │   └── edit.blade.php      # Sửa sản phẩm
    │   └── orders/
    │       ├── index.blade.php     # Danh sách đơn hàng
    │       └── show.blade.php      # Chi tiết đơn
    │
    ├── build-pc.blade.php      # Build PC configurator
    ├── pc-gaming/
    │   └── index.blade.php     # Pre-built PC Gaming
    │
    ├── auth/               # Authentication views (Breeze)
    │   ├── login.blade.php
    │   ├── register.blade.php
    │   └── forgot-password.blade.php
    │
    └── welcome.blade.php   # Trang chủ
```

**💡 Blade Templates:**
- `@extends('layouts.app')` - Kế thừa layout
- `@section('content')` - Định nghĩa nội dung
- `@yield('content')` - Nơi hiển thị nội dung
- `{{ $variable }}` - Echo variable (escaped)
- `{!! $html !!}` - Echo HTML (unescaped)

---

### 4️⃣ `routes/` - URL Routing

```
routes/
├── web.php       # ⭐ WEB ROUTES - 70+ routes định nghĩa
├── api.php       # API routes (JSON responses)
├── console.php   # Console commands
└── auth.php      # Auth routes (Breeze)
```

**📍 `web.php` - Route Structure:**
```php
// Public routes (không cần login)
Route::get('/', HomeController::class)->name('home');
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');
Route::get('/build-pc', [PcGamingController::class, 'buildPc'])->name('build-pc');

// Auth required routes
Route::middleware('auth')->group(function () {
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add');
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
});

// Admin routes (auth + admin middleware)
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('products', ProductController::class);
    Route::resource('orders', OrderController::class);
});
```

**💡 Route Methods:**
- `Route::get()` - Hiển thị trang
- `Route::post()` - Gửi form (create)
- `Route::patch()` - Cập nhật
- `Route::delete()` - Xóa
- `Route::resource()` - CRUD đầy đủ (7 routes)

---

### 5️⃣ `config/` - Configuration Files

```
config/
├── app.php          # App name, timezone, providers
├── database.php     # Database connections (MySQL)
├── auth.php         # Authentication guards, providers
├── mail.php         # Email configuration
├── cache.php        # Cache drivers
└── services.php     # Third-party services (Stripe, PayOS...)
```

**💡 Cách dùng:**
```php
// Lấy config value
config('app.name');                    // "UITech Store"
config('database.default');            // "mysql"

// Set config runtime
config(['app.debug' => false]);
```

---

### 6️⃣ `public/` - Public Assets & Entry Point

```
public/
├── index.php         # ⭐ ENTRY POINT - Điểm vào duy nhất của Laravel
├── .htaccess         # Apache rewrite rules
│
├── build/            # Compiled assets (by Vite)
│   ├── assets/
│   │   ├── app-[hash].js
│   │   └── app-[hash].css
│   └── manifest.json
│
└── images/           # Static images
    ├── logo/
    │   └── uitech-logo.png
    └── products/
        ├── cpu/
        ├── gpu/
        └── ... (1000+ product images)
```

**💡 URL Mapping:**
- `http://localhost:8000/` → `public/index.php`
- `http://localhost:8000/images/logo.png` → `public/images/logo.png`
- `http://localhost:8000/products` → `routes/web.php` → `ProductController@index`

---

### 7️⃣ `storage/` - Runtime Files (DON'T COMMIT)

```
storage/
├── app/              # Application files
│   ├── public/       # Public uploads (symlinked to public/storage)
│   └── private/      # Private files
│
├── framework/        # Laravel framework cache
│   ├── cache/        # Cache files
│   ├── sessions/     # Session files
│   └── views/        # Compiled Blade views
│
└── logs/             # Application logs
    └── laravel.log   # Error logs
```

**💡 Symlink storage:**
```powershell
php artisan storage:link
# Tạo symlink: public/storage → storage/app/public
```

---

### 8️⃣ `tests/` - Automated Testing

```
tests/
├── Unit/             # Unit tests (test 1 method/class)
└── Feature/          # Feature tests (test full workflow)
```

---

## 🔄 FLOW: User Request → Response

```
1. User truy cập: http://localhost:8000/products

2. Apache/Nginx → public/index.php (entry point)

3. index.php → bootstrap/app.php → Kernel.php

4. Kernel → routes/web.php → tìm route '/products'

5. Route → ProductController@index

6. Controller:
   - Query database qua Product model
   - $products = Product::paginate(20);

7. Controller → return view('products.index', compact('products'));

8. View:
   - Blade engine compile resources/views/products/index.blade.php
   - Replace {{ $product->name }} với data thật

9. Response: HTML rendered → trả về browser

10. Browser: Render HTML + load CSS/JS từ public/build/
```

---

## 📊 DATABASE RELATIONSHIPS

```
users (1)
  ├─── (many) carts
  │      └─── (many) cart_items
  │             └─── (1) products
  │
  ├─── (many) orders
  │      └─── (many) order_items
  │             └─── (1) products
  │
  └─── (many) user_addresses

products (1)
  ├─── (many) product_images
  ├─── (many) product_specs
  │      └─── (1) spec_definitions
  │
  ├─── (1) category
  ├─── (1) brand
  └─── (1) component_type
```

---

## 🎯 NAMING CONVENTIONS

| Item | Convention | Example |
|------|-----------|---------|
| **Model** | Singular, PascalCase | `Product`, `OrderItem` |
| **Table** | Plural, snake_case | `products`, `order_items` |
| **Controller** | PascalCase + Controller | `ProductController` |
| **Route name** | Dot notation, lowercase | `products.index`, `cart.add` |
| **View** | Lowercase, dash/dot | `products/index.blade.php` |
| **Variable** | camelCase | `$totalPrice`, `$cartItems` |
| **Method** | camelCase, verb | `getTotal()`, `addToCart()` |

---

## 🔧 IMPORTANT FILES

| File | Mục đích | Khi nào edit |
|------|---------|-------------|
| `.env` | Environment config (DB, mail...) | Setup project lần đầu |
| `composer.json` | PHP dependencies | Khi cài package mới |
| `package.json` | NPM dependencies | Khi cài JS library |
| `routes/web.php` | Định nghĩa routes | Thêm URL mới |
| `database/migrations/` | Database schema | Tạo/sửa bảng |
| `database/seeders/` | Sample data | Thêm dữ liệu mẫu |

---

## 💡 TIPS CHO NGƯỜI MỚI

### 1. Muốn tạo trang mới?
```powershell
# 1. Tạo controller
php artisan make:controller ContactController

# 2. Tạo method trong controller
public function index() {
    return view('contact');
}

# 3. Tạo view
resources/views/contact.blade.php

# 4. Thêm route
Route::get('/contact', [ContactController::class, 'index'])->name('contact');
```

### 2. Muốn thêm bảng mới?
```powershell
# 1. Tạo migration
php artisan make:migration create_wishlists_table

# 2. Định nghĩa schema trong migration
Schema::create('wishlists', function (Blueprint $table) {
    $table->id();
    $table->foreignId('user_id')->constrained();
    $table->foreignId('product_id')->constrained();
    $table->timestamps();
});

# 3. Chạy migration
php artisan migrate

# 4. Tạo model
php artisan make:model Wishlist

# 5. Định nghĩa relationships trong model
```

### 3. Debug
```powershell
# Xem logs
storage/logs/laravel.log

# Xem queries
DB::enableQueryLog();
// your code
dd(DB::getQueryLog());

# Dump & die
dd($variable);

# Tinker (Laravel REPL)
php artisan tinker
>>> User::count()
>>> Product::find(1)
```

---

## 📚 HỌC THÊM

- **Laravel Docs:** https://laravel.com/docs/10.x
- **Laracasts:** https://laracasts.com (Video tutorials)
- **Laravel Daily:** https://laraveldaily.com
- **Blade Templates:** https://laravel.com/docs/10.x/blade

---

**Cập nhật:** 15/11/2025  
**Tác giả:** UITech Development Team
