# UITech - Cấu Trúc Dự Án (Project Structure)

**Dự án**: UITech - Hệ Thống Bán Linh Kiện Máy Tính  
**Môn học**: IS207 - Phát Triển Ứng Dụng Web (IS207.P11)  
**Trường**: Đại học Công nghệ Thông tin - ĐHQG TP.HCM  
**Ngày cập nhật**: 14/11/2025

---

## 📁 CẤU TRÚC THƯ MỤC TỔNG QUAN

```
pc-parts-e-store-boilerplate/
├── app/                          # Mã nguồn ứng dụng Laravel
├── bootstrap/                    # Khởi động framework
├── config/                       # Cấu hình ứng dụng
├── database/                     # Database: migrations, seeders, factories
├── docs/                         # Tài liệu kỹ thuật chi tiết
├── public/                       # Web root (index.php, assets)
├── resources/                    # Views, CSS, JS
├── routes/                       # Định nghĩa routes
├── storage/                      # Logs, cache, uploads
├── tests/                        # Unit & Feature tests
├── vendor/                       # Dependencies (Composer)
├── .env                          # Biến môi trường
├── artisan                       # CLI Laravel
├── composer.json                 # PHP dependencies
├── package.json                  # JS dependencies
├── README.md                     # Hướng dẫn đồ án
└── tailwind.config.js            # Cấu hình Tailwind CSS
```

---

## 🗂️ CHI TIẾT CẤU TRÚC THƯ MỤC

### 1. **app/** - Mã Nguồn Ứng Dụng

```
app/
├── Console/                      # CLI commands
├── Exceptions/                   # Exception handlers
├── Http/
│   ├── Controllers/              # Controllers (xử lý logic)
│   │   ├── Admin/
│   │   │   ├── DashboardController.php    # Dashboard quản trị
│   │   │   ├── OrderController.php        # Quản lý đơn hàng (admin)
│   │   │   └── ProductController.php      # Quản lý sản phẩm (admin)
│   │   ├── CartController.php             # Giỏ hàng
│   │   ├── CheckoutController.php         # Thanh toán
│   │   ├── OrderController.php            # Đơn hàng (user)
│   │   └── ProductController.php          # Xem sản phẩm (user)
│   └── Middleware/               # Middleware (xác thực, phân quyền)
│       ├── AdminMiddleware.php            # Phân quyền Admin
│       ├── Authenticate.php
│       ├── VerifyCsrfToken.php
│       └── ... (Laravel default middlewares)
├── Models/                       # Eloquent Models (8 models)
│   ├── Cart.php                  # Model giỏ hàng
│   ├── CartItem.php              # Model item trong giỏ
│   ├── Category.php              # Model danh mục
│   ├── Order.php                 # Model đơn hàng
│   ├── OrderItem.php             # Model item trong đơn hàng
│   ├── Product.php               # Model sản phẩm
│   ├── ProductImage.php          # Model hình ảnh sản phẩm
│   └── User.php                  # Model người dùng
└── Providers/                    # Service providers
```

**Chi tiết Models:**
- **User**: Người dùng (role: user/admin)
- **Category**: Danh mục sản phẩm (CPU, GPU, RAM, ...)
- **Product**: Sản phẩm (stock, brand, specifications JSON, image)
- **ProductImage**: Hình ảnh sản phẩm (1-n với Product)
- **Cart**: Giỏ hàng (thuộc User)
- **CartItem**: Item trong giỏ (thuộc Cart, Product)
- **Order**: Đơn hàng (status, total_amount, shipping_address)
- **OrderItem**: Item trong đơn (thuộc Order, Product)

---

### 2. **database/** - Cơ Sở Dữ Liệu

```
database/
├── factories/                    # Model factories (testing)
├── migrations/                   # Migration files (11 files)
│   ├── 2025_11_01_000001_create_categories_table.php
│   ├── 2025_11_01_000002_create_products_table.php
│   ├── 2025_11_01_000003_create_orders_table.php
│   ├── 2025_11_01_000004_create_order_items_table.php
│   ├── 2025_11_01_000005_add_role_to_users_table.php
│   ├── 2025_11_01_000006_create_product_images_table.php
│   ├── 2025_11_01_000012_create_carts_table.php
│   ├── 2025_11_01_000013_create_cart_items_table.php
│   ├── 2025_11_01_000014_update_orders_table.php
│   ├── 2025_11_14_000001_update_products_table_add_simplified_fields.php
│   └── 2025_11_14_000002_update_orders_table_add_shipping_fields.php
└── seeders/                      # Database seeders (4 files)
    ├── AdminUserSeeder.php       # Tạo tài khoản admin
    ├── CategorySeeder.php        # Danh mục sản phẩm
    ├── DatabaseSeeder.php        # Seeder chính
    └── ProductSeeder.php         # 6 sản phẩm mẫu
```

**Cấu trúc Database (8 bảng chính):**
1. **users**: id, name, email, password, role (user/admin)
2. **categories**: id, name, slug, description
3. **products**: id, name, slug, description, price, stock, brand, specifications (JSON), image, category_id
4. **product_images**: id, product_id, image_path, is_primary
5. **carts**: id, user_id
6. **cart_items**: id, cart_id, product_id, quantity, price
7. **orders**: id, user_id, order_number, status, total_amount, payment_method, shipping_name, shipping_address, shipping_city, shipping_phone
8. **order_items**: id, order_id, product_id, quantity, price

---

### 3. **resources/** - Views & Assets

```
resources/
├── css/
│   └── app.css                   # Tailwind CSS + custom styles
├── js/
│   └── app.js                    # JavaScript chính
└── views/                        # Blade templates
    ├── admin/                    # Views quản trị
    │   ├── dashboard.blade.php
    │   ├── orders/
    │   └── products/
    │       ├── create.blade.php
    │       ├── edit.blade.php
    │       └── index.blade.php
    ├── blog/                     # Blog (nếu có)
    ├── cart/
    │   └── index.blade.php       # Trang giỏ hàng
    ├── checkout/
    │   └── index.blade.php       # Trang thanh toán
    ├── components/               # Blade components
    │   └── product-card.blade.php  # Component card sản phẩm
    ├── layouts/
    │   ├── admin.blade.php       # Layout admin
    │   └── app.blade.php         # Layout chính
    ├── orders/
    │   ├── index.blade.php       # Danh sách đơn hàng
    │   └── show.blade.php        # Chi tiết đơn hàng
    ├── partials/
    │   ├── footer.blade.php
    │   └── header.blade.php
    ├── products/
    │   ├── index.blade.php       # Danh sách sản phẩm
    │   └── show.blade.php        # Chi tiết sản phẩm
    └── welcome.blade.php         # Trang chủ
```

---

### 4. **routes/** - Định Nghĩa Routes

```
routes/
└── web.php                       # Web routes chính
```

**Nhóm routes:**
- **Public**: `/` (home), `/products`, `/products/{slug}`
- **Auth (đã comment)**: `/cart`, `/checkout`, `/orders`
- **Admin (đã comment)**: `/admin/dashboard`, `/admin/products`, `/admin/orders`

---

### 5. **docs/** - Tài Liệu Kỹ Thuật

```
docs/
├── NhiemVu.md                    # Phân công nhiệm vụ
├── POST_INSTALL.txt              # Hướng dẫn sau cài đặt
├── PROJECT_PROGRESS_REPORT.md    # Báo cáo tiến độ
├── README.md                     # Index tài liệu
├── README_TECHNICAL.md           # README kỹ thuật chi tiết (775 dòng)
└── TODO_FEATURES.md              # Roadmap tính năng
```

---

### 6. **config/** - Cấu Hình Ứng Dụng

```
config/
├── app.php                       # Cấu hình chính (name: UITech)
├── auth.php                      # Cấu hình authentication
├── database.php                  # Kết nối database
├── filesystems.php               # Storage config
├── mail.php                      # Mail config
└── ... (Laravel default configs)
```

---

## 🔧 CẤU HÌNH MÔI TRƯỜNG (.env)

```env
APP_NAME=UITech
APP_ENV=local
APP_KEY=base64:...
APP_DEBUG=true
APP_URL=http://localhost

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=uitech
DB_USERNAME=root
DB_PASSWORD=

# ... (các biến khác)
```

---

## 📦 DEPENDENCIES (Package Management)

### PHP Dependencies (composer.json)
```json
{
  "name": "duckonthemic/uitech",
  "description": "UITech - Hệ thống bán linh kiện máy tính",
  "require": {
    "php": "^8.3",
    "laravel/framework": "^10.0"
  }
}
```

### JavaScript Dependencies (package.json)
```json
{
  "name": "uitech",
  "scripts": {
    "dev": "vite",
    "build": "vite build"
  },
  "devDependencies": {
    "tailwindcss": "^3.3.0",
    "alpinejs": "^3.x.x"
  }
}
```

---

## 🎨 FRONTEND STACK

- **CSS Framework**: Tailwind CSS 3.3 (via CDN)
- **JavaScript**: Alpine.js 3.x (via CDN)
- **Build Tool**: Vite
- **Icons**: Heroicons (optional)

---

## 🚀 BACKEND STACK

- **Framework**: Laravel 10.49.1
- **PHP Version**: 8.3.26
- **Database**: MySQL 8.0+
- **Authentication**: Laravel Breeze (planned)
- **Architecture**: MVC (Model-View-Controller)

---

## 📊 THỐNG KÊ DỰ ÁN

### Quy mô code
- **Models**: 8 files
- **Controllers**: 5 files
- **Migrations**: 11 files
- **Views**: 20+ files
- **Routes**: 1 file chính (~60 dòng)
- **README**: 300 dòng (course format)

### So sánh trước/sau đơn giản hóa
| Metric                | Trước | Sau |
|-----------------------|-------|-----|
| Models                | 19    | 8   |
| Database Tables       | 20+   | 8   |
| README Lines          | 775   | 300 |
| ProductController     | 150   | 65  |
| Routes                | 40+   | 25  |

---

## 🔐 PHÂN QUYỀN VÀ BẢO MẬT

### Roles
1. **user**: Người dùng thông thường (xem, mua sản phẩm)
2. **admin**: Quản trị viên (quản lý sản phẩm, đơn hàng)

### Middleware
- `auth`: Xác thực người dùng đã đăng nhập
- `admin`: Phân quyền admin (AdminMiddleware.php)
- `verified`: Email verification
- `guest`: Chưa đăng nhập

---

## 📝 CHỨC NĂNG CHÍNH

### User-facing
1. ✅ Xem danh sách sản phẩm (tìm kiếm, lọc, sắp xếp)
2. ✅ Xem chi tiết sản phẩm
3. 🔄 Thêm vào giỏ hàng (cần auth)
4. 🔄 Thanh toán (cần auth)
5. 🔄 Quản lý đơn hàng cá nhân (cần auth)

### Admin
1. 🔄 Dashboard quản trị (cần auth + admin)
2. 🔄 Quản lý sản phẩm: CRUD (cần auth + admin)
3. 🔄 Quản lý đơn hàng: xem, cập nhật trạng thái (cần auth + admin)

**Ghi chú**: ✅ = Hoàn thành, 🔄 = Đang phát triển/cần auth

---

## 🛠️ CÔNG NGHỆ SỬ DỤNG

### Backend
- Laravel 10.49.1 (PHP Framework)
- Eloquent ORM (Database abstraction)
- Blade Template Engine

### Frontend
- Tailwind CSS 3.3 (Utility-first CSS)
- Alpine.js 3.x (Lightweight JS framework)
- Vite (Build tool)

### Database
- MySQL 8.0+
- Laravel Migrations (Schema management)
- Eloquent Relationships

### Tools
- Composer (PHP package manager)
- npm (JavaScript package manager)
- Git (Version control)

---

## 📚 TÀI LIỆU THAM KHẢO

- **README chính**: `/README.md` - Hướng dẫn cài đặt đồ án
- **README kỹ thuật**: `/docs/README_TECHNICAL.md` - Chi tiết kiến trúc
- **Nhiệm vụ**: `/docs/NhiemVu.md` - Phân công công việc
- **Roadmap**: `/docs/TODO_FEATURES.md` - Kế hoạch phát triển
- **Progress Report**: `/docs/PROJECT_PROGRESS_REPORT.md` - Báo cáo tiến độ

---

## 👥 THÀNH VIÊN NHÓM

1. Nguyễn Huy Hoàng - 23521456
2. Lê Hoàng Phúc - 23520392
3. Trần Thiện Hùng - 23521520
4. Nguyễn Hoàng Duy - 23520343
5. Trần Thanh Bình - 23520138
6. Nguyễn Văn Thiện - 23521412

**Giảng viên hướng dẫn**: TS. Nguyễn Thị Thanh Trúc

---

## 🎯 MỤC TIÊU DỰ ÁN

Xây dựng hệ thống bán linh kiện máy tính trực tuyến với các chức năng:
- Quản lý sản phẩm theo danh mục
- Giỏ hàng và thanh toán
- Quản lý đơn hàng
- Phân quyền user/admin

**Đặc điểm**:
- Giao diện responsive với Tailwind CSS
- Kiến trúc MVC rõ ràng
- Code đơn giản, dễ bảo trì (phù hợp đồ án môn học)
- Tài liệu đầy đủ (README + docs/)

---

## 📌 LƯU Ý

1. **Cài đặt Laravel Breeze**: Chưa cài đặt, cần chạy `composer require laravel/breeze` và `php artisan breeze:install`
2. **Database**: Cần tạo database `uitech` trong MySQL trước khi chạy migrations
3. **MySQL Server**: Cần khởi động MySQL server trước khi test
4. **Routes đã comment**: Các routes yêu cầu auth đã được comment, uncomment sau khi cài Breeze
5. **Admin Seeder**: Chạy `AdminUserSeeder` để tạo tài khoản admin mặc định

---

## 📈 HƯỚNG PHÁT TRIỂN TIẾP THEO

1. ✅ Cài đặt Laravel Breeze (authentication)
2. ✅ Uncomment routes cần auth
3. ✅ Hoàn thiện checkout flow
4. ✅ Implement admin dashboard
5. ✅ Thêm payment gateway (VNPay, Momo)
6. ✅ Upload hình ảnh sản phẩm
7. ✅ Email notifications
8. ✅ Testing (PHPUnit)

---

**Tài liệu này được tạo tự động vào ngày 14/11/2025**  
**Repository**: https://github.com/duckonthemic/IS207_Final  
**Branch**: main
