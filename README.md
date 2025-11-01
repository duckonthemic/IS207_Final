# PC Parts E-Store (Laravel 10.x + Tailwind CSS)

Website thương mại điện tử bán linh kiện máy tính. Kiến trúc MVC với Laravel, MySQL, Blade, Tailwind CSS; auth dùng Laravel Breeze (hoặc Jetstream).

## Tính năng chính
- Khu vực người dùng: Trang chủ, Giới thiệu, Liên hệ, Blog; danh sách/chi tiết sản phẩm; lọc & tìm kiếm; giỏ hàng (Session); checkout giả lập.
- Khu vực Admin: Dashboard; CRUD sản phẩm (soft deletes), quản lý đơn hàng/người dùng (mở rộng), thống kê cơ bản.

## Cài đặt nhanh
1. **Clone & cài đặt phụ thuộc**
   ```bash
   composer create-project laravel/laravel pc-parts-e-store && cd pc-parts-e-store
   ```
   Sao chép các file từ thư mục `pc-parts-e-store-boilerplate/` này đè lên dự án.
   ```bash
   composer install
   npm install
   ```
2. **Env & key**
   ```bash
   cp .env.example .env
   php artisan key:generate
   # Cập nhật DB_* trong .env cho MySQL
   ```
3. **Tailwind (chọn 1)**
   - Dùng Vite: cấu hình sẵn trong `resources/css/app.css`, chạy `npm run dev`.
   - Hoặc dùng CDN (đã thêm trong layout) để demo nhanh.
4. **Auth (Breeze)**
   ```bash
   composer require laravel/breeze --dev
   php artisan breeze:install blade
   npm install && npm run dev
   php artisan migrate
   ```
5. **Migrate & Seed**
   ```bash
   php artisan migrate --seed
   ```

## Tài khoản Admin mặc định
- Email: **admin@pcparts.local**
- Mật khẩu: **password**
> Được tạo bởi `AdminUserSeeder`. Hãy đổi mật khẩu sau khi đăng nhập.

## Phân quyền
- Đăng ký middleware `admin` trong `app/Http/Kernel.php`:
  ```php
  protected $routeMiddleware = [
      // ...
      'admin' => \App\Http\Middleware\AdminMiddleware::class,
  ];
  ```

## Định hướng mở rộng
| Nhóm | Ý tưởng nâng cao |
|---|---|
| Sản phẩm | Thuộc tính kỹ thuật (RAM/CPU/GPU), biến thể SKU, ảnh gallery, slug tự sinh |
| Tìm kiếm | Tìm kiếm nâng cao, full‑text/MySQL BOOLEAN MODE, gợi ý từ khoá |
| Giỏ hàng/Thanh toán | Mã giảm giá, phí ship, tích hợp cổng thanh toán sandbox (Stripe, PayOS) |
| Đơn hàng | Trạng thái chi tiết, email thông báo, hoá đơn PDF, địa chỉ giao nhận |
| Người dùng | Hồ sơ, sổ địa chỉ, wishlist, so sánh sản phẩm |
| Admin | Quản lý danh mục, người dùng, phân quyền chi tiết (Gate/Policy), nhật ký hoạt động |
| Hiệu năng | Cache, eager loading, pagination thông minh |
| UI/UX | Component Blade/Tailwind, dark mode, skeleton loading |

## Ghi chú
- Không ghi đè `app/Http/Kernel.php` của bạn; chỉ thêm middleware theo hướng dẫn trên.
- Khi triển khai thật, thay CDN Tailwind bằng Vite và xử lý upload ảnh qua Storage.
