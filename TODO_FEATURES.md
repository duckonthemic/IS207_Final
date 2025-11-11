# Danh sách Chức năng Còn thiếu & Hướng dẫn Thực hiện

## 📋 Tổng quan

File này liệt kê các chức năng chưa hoàn thành và hướng dẫn chi tiết cách thực hiện.

---

## ✅ Chức năng Đã hoàn thành

| Chức năng | Trạng thái | Files liên quan |
|-----------|-----------|-----------------|
| Trang chủ | ✅ | `resources/views/welcome.blade.php` |
| Trang giới thiệu | ✅ | `resources/views/about.blade.php` |
| Trang liên hệ | ✅ | `resources/views/contact.blade.php` |
| Trang blog | ✅ | `resources/views/blog/index.blade.php` |
| Layout chính | ✅ | `resources/views/layouts/app.blade.php` |
| Header/Footer | ✅ | `resources/views/partials/header.blade.php`, `footer.blade.php` |
| Database migrations | ✅ | `database/migrations/*.php` |
| Models | ✅ | `app/Models/*.php` |

---

## ❌ Chức năng Còn thiếu

### 1. AUTHENTICATION (Đăng nhập/Đăng ký) - CAO ƯU TIÊN

#### Mô tả
Người dùng có thể đăng ký tài khoản, đăng nhập, đăng xuất.

#### Nơi lưu file
```
routes/
  └── auth.php                    # Auth routes (tạo bởi Breeze)
resources/views/auth/
  ├── login.blade.php             # Form đăng nhập
  ├── register.blade.php          # Form đăng ký
  ├── forgot-password.blade.php   # Quên mật khẩu
  └── reset-password.blade.php    # Reset mật khẩu
app/Http/Controllers/Auth/
  ├── AuthenticatedSessionController.php
  ├── RegisteredUserController.php
  └── ...
```

#### Cách thực hiện

**Bước 1: Cài đặt Laravel Breeze**
```bash
composer require laravel/breeze --dev
php artisan breeze:install blade
```

**Bước 2: Chạy migrations**
```bash
php artisan migrate
```

**Bước 3: Compile assets**
```bash
npm install
npm run dev
```

**Bước 4: Uncomment routes trong `routes/web.php`**
```php
// Dòng cuối file
require __DIR__.'/auth.php';
```

**Bước 5: Uncomment auth section trong header**
File: `resources/views/partials/header.blade.php` (dòng 48-66)

---

### 2. DANH SÁCH SẢN PHẨM - CAO ƯU TIÊN

#### Mô tả
Hiển thị danh sách sản phẩm với pagination, search, filter.

#### Nơi lưu file
```
✅ app/Http/Controllers/ProductController.php    # Đã có
✅ app/Models/Product.php                        # Đã có
❌ resources/views/products/index.blade.php      # CẦN TẠO
❌ resources/views/products/show.blade.php       # CẦN TẠO
```

#### Cách thực hiện

**Bước 1: Tạo view danh sách sản phẩm**

File: `resources/views/products/index.blade.php`
```blade
@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-12">
    <h1 class="text-3xl font-bold mb-8">Sản phẩm</h1>
    
    {{-- Search & Filter --}}
    <div class="mb-6">
        <form method="GET" class="flex gap-4">
            <input type="text" name="q" placeholder="Tìm kiếm..." 
                   value="{{ request('q') }}"
                   class="flex-1 px-4 py-2 border rounded">
            <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded">
                Tìm kiếm
            </button>
        </form>
    </div>

    {{-- Product Grid --}}
    <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @forelse($products as $product)
            <div class="bg-white rounded-lg shadow p-4">
                <img src="{{ $product->image ?? 'https://via.placeholder.com/300' }}" 
                     alt="{{ $product->name }}" class="w-full h-48 object-cover rounded mb-4">
                <h3 class="font-semibold text-lg mb-2">{{ $product->name }}</h3>
                <p class="text-gray-600 mb-4">{{ number_format($product->price) }} đ</p>
                <a href="{{ route('products.show', $product->slug) }}" 
                   class="block text-center bg-blue-600 text-white px-4 py-2 rounded">
                    Xem chi tiết
                </a>
            </div>
        @empty
            <p class="col-span-full text-center text-gray-500">Chưa có sản phẩm nào.</p>
        @endforelse
    </div>

    {{-- Pagination --}}
    <div class="mt-8">
        {{ $products->links() }}
    </div>
</div>
@endsection
```

**Bước 2: Tạo view chi tiết sản phẩm**

File: `resources/views/products/show.blade.php`
```blade
@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-12">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        {{-- Product Image --}}
        <div>
            <img src="{{ $product->image ?? 'https://via.placeholder.com/600' }}" 
                 alt="{{ $product->name }}" class="w-full rounded-lg shadow">
        </div>

        {{-- Product Info --}}
        <div>
            <h1 class="text-3xl font-bold mb-4">{{ $product->name }}</h1>
            <p class="text-2xl text-blue-600 font-bold mb-6">
                {{ number_format($product->price) }} đ
            </p>
            <p class="text-gray-700 mb-6">{{ $product->description }}</p>
            
            <div class="mb-6">
                <p><strong>Danh mục:</strong> {{ $product->category->name }}</p>
                <p><strong>Còn lại:</strong> {{ $product->stock }} sản phẩm</p>
            </div>

            @auth
                <form method="POST" action="{{ route('cart.add') }}">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <button type="submit" class="w-full bg-blue-600 text-white px-6 py-3 rounded-lg text-lg font-semibold">
                        Thêm vào giỏ hàng
                    </button>
                </form>
            @else
                <a href="{{ route('login') }}" class="block text-center bg-gray-600 text-white px-6 py-3 rounded-lg">
                    Đăng nhập để mua hàng
                </a>
            @endauth
        </div>
    </div>
</div>
@endsection
```

**Bước 3: Seed dữ liệu mẫu**

File: `database/seeders/ProductSeeder.php` (TẠO MỚI)
```php
<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        // Tạo categories
        $cpu = Category::create(['name' => 'CPU', 'slug' => 'cpu']);
        $gpu = Category::create(['name' => 'GPU', 'slug' => 'gpu']);
        $ram = Category::create(['name' => 'RAM', 'slug' => 'ram']);

        // Tạo products
        $products = [
            ['name' => 'Intel Core i9-13900K', 'category_id' => $cpu->id, 'price' => 15000000, 'stock' => 10],
            ['name' => 'AMD Ryzen 9 7950X', 'category_id' => $cpu->id, 'price' => 14000000, 'stock' => 8],
            ['name' => 'NVIDIA RTX 4090', 'category_id' => $gpu->id, 'price' => 45000000, 'stock' => 5],
            ['name' => 'AMD RX 7900 XTX', 'category_id' => $gpu->id, 'price' => 25000000, 'stock' => 7],
            ['name' => 'Corsair 32GB DDR5', 'category_id' => $ram->id, 'price' => 5000000, 'stock' => 20],
        ];

        foreach ($products as $data) {
            Product::create([
                'name' => $data['name'],
                'slug' => Str::slug($data['name']),
                'description' => 'Sản phẩm chất lượng cao',
                'price' => $data['price'],
                'stock' => $data['stock'],
                'category_id' => $data['category_id'],
            ]);
        }
    }
}
```

Chạy seeder:
```bash
php artisan db:seed --class=ProductSeeder
```

---

### 3. GIỎ HÀNG (Shopping Cart) - TRUNG BÌNH ƯU TIÊN

#### Nơi lưu file
```
✅ app/Http/Controllers/CartController.php       # Đã có
❌ resources/views/cart/index.blade.php          # CẦN TẠO
```

#### Cách thực hiện

**Bước 1: Tạo view giỏ hàng**

File: `resources/views/cart/index.blade.php`
```blade
@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-12">
    <h1 class="text-3xl font-bold mb-8">Giỏ hàng</h1>

    @if(session('cart') && count(session('cart')) > 0)
        <div class="bg-white rounded-lg shadow p-6">
            <table class="w-full">
                <thead>
                    <tr class="border-b">
                        <th class="text-left py-3">Sản phẩm</th>
                        <th class="text-center py-3">Số lượng</th>
                        <th class="text-right py-3">Giá</th>
                        <th class="text-right py-3">Tổng</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @php $total = 0; @endphp
                    @foreach(session('cart') as $id => $item)
                        @php $subtotal = $item['price'] * $item['quantity']; $total += $subtotal; @endphp
                        <tr class="border-b">
                            <td class="py-4">{{ $item['name'] }}</td>
                            <td class="text-center">
                                <form method="POST" action="{{ route('cart.update') }}" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="id" value="{{ $id }}">
                                    <input type="number" name="quantity" value="{{ $item['quantity'] }}" 
                                           min="1" class="w-16 px-2 py-1 border rounded text-center">
                                    <button type="submit" class="ml-2 text-blue-600">Cập nhật</button>
                                </form>
                            </td>
                            <td class="text-right">{{ number_format($item['price']) }} đ</td>
                            <td class="text-right font-semibold">{{ number_format($subtotal) }} đ</td>
                            <td class="text-right">
                                <form method="POST" action="{{ route('cart.remove') }}" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <input type="hidden" name="id" value="{{ $id }}">
                                    <button type="submit" class="text-red-600">Xóa</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3" class="text-right py-4 font-bold">Tổng cộng:</td>
                        <td class="text-right py-4 font-bold text-xl">{{ number_format($total) }} đ</td>
                        <td></td>
                    </tr>
                </tfoot>
            </table>

            <div class="mt-6 flex justify-end gap-4">
                <form method="POST" action="{{ route('cart.clear') }}">
                    @csrf
                    <button class="px-6 py-2 border border-red-600 text-red-600 rounded">
                        Xóa giỏ hàng
                    </button>
                </form>
                <a href="{{ route('checkout.show') }}" class="px-6 py-2 bg-blue-600 text-white rounded">
                    Thanh toán
                </a>
            </div>
        </div>
    @else
        <div class="text-center py-12">
            <p class="text-gray-500 mb-4">Giỏ hàng trống</p>
            <a href="{{ route('products.index') }}" class="text-blue-600">← Tiếp tục mua sắm</a>
        </div>
    @endif
</div>
@endsection
```

**Bước 2: Implement CartController**

File: `app/Http/Controllers/CartController.php` (CẬP NHẬT)
```php
<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        return view('cart.index');
    }

    public function add(Request $request)
    {
        $product = Product::findOrFail($request->product_id);
        $cart = session()->get('cart', []);

        if(isset($cart[$product->id])) {
            $cart[$product->id]['quantity']++;
        } else {
            $cart[$product->id] = [
                "name" => $product->name,
                "quantity" => 1,
                "price" => $product->price,
                "image" => $product->image
            ];
        }

        session()->put('cart', $cart);
        return redirect()->back()->with('success', 'Đã thêm vào giỏ hàng!');
    }

    public function update(Request $request)
    {
        $cart = session()->get('cart');
        if(isset($cart[$request->id])) {
            $cart[$request->id]['quantity'] = $request->quantity;
            session()->put('cart', $cart);
        }
        return redirect()->back()->with('success', 'Đã cập nhật giỏ hàng!');
    }

    public function remove(Request $request)
    {
        $cart = session()->get('cart');
        if(isset($cart[$request->id])) {
            unset($cart[$request->id]);
            session()->put('cart', $cart);
        }
        return redirect()->back()->with('success', 'Đã xóa sản phẩm!');
    }

    public function clear()
    {
        session()->forget('cart');
        return redirect()->back()->with('success', 'Đã xóa giỏ hàng!');
    }
}
```

**Bước 3: Uncomment routes**

File: `routes/web.php` (Dòng 37-62)

---

### 4. CHECKOUT & ĐƠN HÀNG - TRUNG BÌNH ƯU TIÊN

#### Nơi lưu file
```
❌ app/Http/Controllers/CheckoutController.php   # CẦN TẠO
❌ app/Http/Controllers/OrderController.php      # CẦN TẠO
❌ resources/views/checkout/show.blade.php       # CẦN TẠO
❌ resources/views/orders/index.blade.php        # CẦN TẠO
❌ resources/views/orders/show.blade.php         # CẦN TẠO
```

#### Cách thực hiện

**Bước 1: Tạo CheckoutController**

```bash
php artisan make:controller CheckoutController
```

**Bước 2: Tạo OrderController**

```bash
php artisan make:controller OrderController
```

**Bước 3: Implement logic** (Tương tự như CartController)

---

### 5. ADMIN DASHBOARD - TRUNG BÌNH ƯU TIÊN

#### Nơi lưu file
```
✅ resources/views/admin/dashboard.blade.php     # Đã có
❌ resources/views/admin/products/create.blade.php   # CẦN TẠO
❌ resources/views/admin/products/edit.blade.php     # CẦN TẠO
❌ app/Http/Controllers/Admin/ProductController.php  # CẦN CẬP NHẬT
```

#### Cách thực hiện

**Bước 1: Tạo form tạo sản phẩm**

File: `resources/views/admin/products/create.blade.php`

**Bước 2: Tạo form chỉnh sửa sản phẩm**

File: `resources/views/admin/products/edit.blade.php`

**Bước 3: Implement CRUD trong Admin/ProductController**

---

## 📅 Lộ trình Thực hiện (Ưu tiên)

### Tuần 1: Authentication & Products
1. ✅ Cài Laravel Breeze (2h)
2. ✅ Tạo view products (3h)
3. ✅ Seed dữ liệu mẫu (1h)

### Tuần 2: Cart & Checkout
1. ✅ Implement giỏ hàng (4h)
2. ✅ Implement checkout (3h)
3. ✅ Test workflow mua hàng (1h)

### Tuần 3: Admin & Polishing
1. ✅ Admin CRUD products (4h)
2. ✅ Admin quản lý đơn hàng (3h)
3. ✅ Polish UI/UX (1h)

---

## 📝 Ghi chú Quan trọng

1. **Làm theo thứ tự ưu tiên** để đảm bảo các chức năng phụ thuộc hoạt động
2. **Test từng chức năng** trước khi chuyển sang chức năng tiếp theo
3. **Commit thường xuyên** để dễ rollback nếu có lỗi
4. **Uncomment routes** sau khi tạo xong controllers & views

---

**Cập nhật lần cuối:** 11/11/2025
