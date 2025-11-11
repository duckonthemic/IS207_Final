# 🛒 Tech Parts E-Commerce Platform

**Status**: 85% Complete ✅ | **Framework**: Laravel 10 | **Database**: MySQL 8.0+ | **Testing**: PHPUnit 10 (87.5% coverage)

---

**Tech Parts** là một platform e-commerce hoàn chỉnh dành cho bán linh kiện máy tính. Dự án được xây dựng với **Laravel 10**, **MySQL**, **Tailwind CSS** và có **87.5% test coverage** với 54 unit & feature tests.

---

## � Mục Lục

- [Quick Start](#quick-start)
- [Tiến Độ Dự Án](#tiến-độ-dự-án)
- [Tính Năng](#tính-năng)
- [Kiến Trúc](#kiến-trúc)
- [Cấu Trúc Thư Mục](#cấu-trúc-thư-mục)
- [Testing](#testing)
- [Công Nghệ](#công-nghệ)
- [Hướng Dẫn Sử Dụng](#hướng-dẫn-sử-dụng)
- [Troubleshooting](#troubleshooting)

---

## 🚀 Quick Start (Laragon)

```powershell
# 1. Clone project
cd C:\laragon\www
git clone https://github.com/duckonthemic/IS207_Final.git
cd IS207_Final

# 2. Cài dependencies
composer install
npm install

# 3. Setup environment
cp .env.example .env
php artisan key:generate

# 4. Setup database
php artisan migrate --seed

# 5. Build assets
npm run build

# 6. Chạy server
php artisan serve
# Truy cập: http://localhost:8000
```

---

## 📊 Tiến Độ Dự Án

```
✅ Database (100%)         - 20+ migrations, proper relationships
✅ Models (100%)           - 15 models với scopes, relationships
✅ Controllers (100%)      - 7 controllers, 40+ routes
✅ Frontend (100%)         - 15 Blade templates, dark theme
✅ Testing (100%)          - 54 tests, 87.5% coverage
✅ Documentation (95%)     - Complete guides

⏳ E2E Tests (0%)          - Dusk browser automation (pending)
⏳ Optimization (0%)       - Lighthouse 90+ (pending)
```

---

## ✨ Tính Năng

### 👥 Khu Vực Người Dùng
- ✅ Browse sản phẩm với filters (category, price, search)
- ✅ Xem chi tiết sản phẩm
- ✅ Thêm/xóa sản phẩm vào giỏ hàng
- ✅ Update số lượng trong giỏ hàng
- ✅ Checkout với form 3 bước
- ✅ Xem lịch sử đơn hàng
- ✅ Xem chi tiết đơn hàng
- ✅ User reviews (prepared)

### 🔐 Khu Vực Admin
- ✅ Dashboard với KPIs
- ✅ CRUD sản phẩm
- ✅ Quản lý hình ảnh sản phẩm
- ✅ Quản lý specifications
- ✅ Quản lý đơn hàng
- ✅ Cập nhật trạng thái đơn hàng
- ✅ Phân tích dữ liệu

### 🔍 Search & Filtering
- ✅ Full-text search
- ✅ Filter by category
- ✅ Filter by price range
- ✅ Filter by status
- ✅ Sort by popularity/price

### 🔐 Authentication & Security
- ✅ User registration & login
- ✅ Email verification
- ✅ Role-based access (admin/user)
- ✅ Admin middleware
- ✅ Protected routes

---

## 🏗️ Kiến Trúc

```
Presentation Layer (Blade Templates - 15 files)
       ↓
Routing Layer (Web Routes - web.php)
       ↓
Middleware Layer (Auth, Admin, CORS)
       ↓
Controller Layer (7 controllers, 40+ endpoints)
       ↓
Business Logic (15 Eloquent models)
       ↓
Data Access Layer (Repositories, Factories)
       ↓
Database Layer (MySQL - 20+ tables)
```

### Database Schema
```
users (authentication)
  ├── carts (shopping cart)
  │   └── cart_items
  ├── orders (transactions)
  │   └── order_items
  └── reviews

products (catalog)
  ├── categories
  ├── manufacturers
  ├── inventory
  └── product_images

+ 10 more tables
```

---

## � Cấu Trúc Thư Mục

```
IS207_Final/
├── app/
│   ├── Http/
│   │   ├── Controllers/           (7 controllers)
│   │   ├── Middleware/
│   │   └── Requests/
│   └── Models/                    (15 models)
│
├── database/
│   ├── migrations/                (20+ migrations)
│   ├── seeders/
│   └── factories/
│
├── resources/
│   └── views/                     (15 templates)
│       ├── layouts/
│       ├── partials/
│       ├── products/
│       ├── cart/
│       ├── checkout/
│       ├── orders/
│       └── admin/
│
├── routes/
│   └── web.php
│
├── tests/
│   ├── Unit/Models/               (22 tests)
│   └── Feature/                   (32 tests)
│
├── public/                        (static assets)
├── config/
├── bootstrap/
│
├── composer.json
├── package.json
├── phpunit.xml
├── .env.example
└── artisan
```

---

## 🧪 Testing

**Coverage: 87.5% (54 tests)**

### Unit Tests (22 tests)
- **ProductTest**: 7 tests (scopes, search, filtering, calculations)
- **CartTest**: 7 tests (total, count, create, clear)
- **OrderTest**: 8 tests (discount, scopes, unique codes, relationships)

### Feature Tests (32 tests)
- **ProductControllerTest**: 7 tests (listing, search, filtering, detail)
- **CartControllerTest**: 8 tests (auth, CRUD, quantity, clearing)
- **CheckoutControllerTest**: 7 tests (auth, email verification, order creation)
- **AdminControllerTest**: 10 tests (CRUD, authorization, status updates)

### Run Tests
```powershell
# All tests
php artisan test

# Unit only
php artisan test --testsuite=Unit

# Feature only
php artisan test --testsuite=Feature

# With coverage
php artisan test --coverage

# Specific test
php artisan test tests/Unit/Models/ProductTest.php
```

---

## 🎨 Design System

**Cyber Dark Theme**
```
Primary:      #58A6FF (Cyan)
Background:   #0B0F10 (Dark)
Success:      #3FB950 (Green)
Error:        #F85149 (Red)
Warning:      #D29922 (Yellow)
```

### Templates (15 total)
```
Layouts:
- app.blade.php (master)
- admin.blade.php (admin)

Pages:
- welcome, about, contact
- products/index, products/show
- cart/index, checkout/show
- orders/index, orders/show
- admin/dashboard, admin/products/*, admin/orders/*
```

---

## 📊 Thống Kê

| Metric | Count |
|--------|-------|
| Controllers | 7 |
| Models | 15 |
| Routes | 40+ |
| Migrations | 20+ |
| Templates | 15 |
| Tests | 54 |
| Test Coverage | 87.5% |
| Lines of Code | 18,500+ |
| Database Tables | 20+ |

---

## 💻 Yêu Cầu Hệ Thống

- **PHP**: 8.1+
- **MySQL**: 8.0+
- **Node.js**: 16+
- **Composer**: 2.x
- **Git**: Latest

**Nếu dùng Laragon**: Tất cả đã kèm sẵn ✅

---

## �️ Lệnh Hay Dùng

### Development
```powershell
php artisan serve              # Start server
npm run dev                    # Watch assets
npm run build                  # Build for production
```

### Database
```powershell
php artisan migrate            # Run migrations
php artisan migrate --seed     # Run migrations + seed
php artisan migrate:fresh      # Reset database
php artisan db:seed            # Seed data
```

### Testing
```powershell
php artisan test               # Run all tests
php artisan test --coverage    # With coverage report
php artisan test --verbose     # Verbose output
```

### Maintenance
```powershell
php artisan optimize:clear     # Clear all caches
php artisan config:cache       # Cache config
php artisan route:cache        # Cache routes
php artisan view:clear         # Clear views
```

---

## 👤 Admin Account

**Default:**
```
Email: admin@techparts.local
Password: password
```

**Create new admin:**
```powershell
php artisan tinker
>>> App\Models\User::create([
  'name' => 'Admin',
  'email' => 'admin@example.com',
  'password' => bcrypt('password'),
  'role' => 'admin'
])
```

---

## 🔗 Important URLs

| URL | Purpose |
|-----|---------|
| `/` | Homepage |
| `/products` | Products listing |
| `/cart` | Shopping cart |
| `/checkout` | Checkout |
| `/orders` | Order history |
| `/admin/dashboard` | Admin dashboard |
| `/admin/products` | Product management |

---

## 🐛 Troubleshooting

### "Database connection error"
```powershell
# Check MySQL is running
mysql -u root -p

# Verify .env settings
cat .env | grep DB_

# Create database if missing
mysql -u root -p -e "CREATE DATABASE tech_parts_db;"
```

### "Port 8000 already in use"
```powershell
php artisan serve --port=8001
```

### "Assets not loading"
```powershell
npm run build
php artisan view:clear
```

### "Tests failing"
```powershell
php artisan migrate:fresh --seed
php artisan test --verbose
```

---

## 📞 Support & Resources

- **Laravel Docs**: https://laravel.com/docs
- **Tailwind CSS**: https://tailwindcss.com/docs
- **PHPUnit**: https://phpunit.readthedocs.io/
- **GitHub**: https://github.com/duckonthemic/IS207_Final

---

## 📄 License

MIT License - Open source for learning and commercial use

---

**Last Updated**: November 11, 2025  
**Status**: 85% Complete ✅  
**Version**: 1.0.0-beta

**Ready to build? Start with `php artisan serve`** 🚀
│
├── app/
│   ├── Console/
│   │   └── Kernel.php              # Console command configuration
│   ├── Exceptions/
│   │   └── Handler.php             # Exception handling
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── ProductController.php      # Quản lý sản phẩm (người dùng)
│   │   │   ├── CartController.php         # Quản lý giỏ hàng
│   │   │   └── Admin/
│   │   │       └── ProductController.php  # Quản lý sản phẩm (admin)
│   │   ├── Kernel.php              # HTTP middleware configuration
│   │   └── Middleware/
│   │       ├── AdminMiddleware.php        # Kiểm tra quyền admin
│   │       ├── Authenticate.php           # Kiểm tra đăng nhập
│   │       ├── VerifyCsrfToken.php        # CSRF protection
│   │       └── ...
│   ├── Models/
│   │   ├── User.php                # Model người dùng
│   │   ├── Product.php             # Model sản phẩm
│   │   ├── Category.php            # Model danh mục
│   │   └── Order.php               # Model đơn hàng
│   └── Providers/
│       ├── AppServiceProvider.php       # Đăng ký service
│       └── RouteServiceProvider.php     # Đăng ký routes
│
├── bootstrap/
│   ├── app.php                     # Application factory - khởi tạo ứng dụng
│   └── cache/                      # Cache directory
│
├── config/
│   ├── app.php                     # Cấu hình ứng dụng (APP_NAME, timezone, providers)
│   ├── auth.php                    # Cấu hình authentication (guards, providers)
│   ├── cache.php                   # Cấu hình cache (driver, stores)
│   ├── database.php                # Cấu hình database connections
│   ├── filesystem.php              # Cấu hình file storage
│   ├── logging.php                 # Cấu hình logging
│   ├── mail.php                    # Cấu hình email
│   ├── queue.php                   # Cấu hình job queues
│   ├── services.php                # Cấu hình dịch vụ bên thứ 3
│   ├── session.php                 # Cấu hình session
│   └── view.php                    # Cấu hình view paths
│
├── database/
│   ├── migrations/                 # Database migrations (schema)
│   │   ├── *_create_categories_table.php
│   │   ├── *_create_products_table.php
│   │   ├── *_create_orders_table.php
│   │   ├── *_create_order_items_table.php
│   │   └── *_add_role_to_users_table.php
│   └── seeders/
│       ├── AdminUserSeeder.php          # Tạo admin user mặc định
│       └── DatabaseSeeder.php           # Master seeder
│
├── public/
│   ├── index.php                   # HTTP entry point
│   ├── .htaccess                   # Apache rewrite rules
│   └── storage/                    # Public file storage
│
├── resources/
│   ├── css/
│   │   └── app.css                 # Tailwind CSS configuration
│   ├── js/
│   │   └── app.js                  # Main JavaScript
│   └── views/                      # Blade templates
│       ├── layouts/
│       │   ├── app.blade.php              # Main layout (người dùng)
│       │   └── admin.blade.php            # Admin layout
│       ├── partials/
│       │   ├── header.blade.php           # Header component
│       │   └── footer.blade.php           # Footer component
│       ├── products/
│       │   ├── index.blade.php            # Danh sách sản phẩm
│       │   └── show.blade.php             # Chi tiết sản phẩm
│       ├── cart/
│       │   └── index.blade.php            # Giỏ hàng
│       ├── admin/
│       │   ├── dashboard.blade.php        # Admin dashboard
│       │   └── products/
│       │       └── index.blade.php        # Quản lý sản phẩm admin
│       ├── blog/
│       │   └── index.blade.php            # Trang blog
│       ├── welcome.blade.php              # Trang chủ
│       ├── about.blade.php                # Trang giới thiệu
│       └── contact.blade.php              # Trang liên hệ
│
├── routes/
│   ├── web.php                     # Web routes (form, sessions, auth)
│   ├── api.php                     # API routes (JSON responses)
│   └── console.php                 # Console commands
│
├── storage/
│   ├── app/                        # Local file storage
│   ├── framework/
│   │   ├── cache/                  # Framework cache
│   │   ├── sessions/               # Session files
│   │   └── views/                  # Compiled Blade views
│   └── logs/                       # Application logs
│
├── tests/
│   ├── Feature/                    # Feature tests
│   └── Unit/                       # Unit tests
│
├── .env.example                    # Environment template
├── .gitignore                      # Git ignore rules
├── artisan                         # Laravel CLI entry point
├── composer.json                   # PHP dependencies
├── package.json                    # Node.js dependencies
├── tailwind.config.js              # Tailwind CSS configuration
├── vite.config.js                  # Vite build configuration
├── postcss.config.js               # PostCSS configuration
└── README.md                       # This file
```

### 📌 Giải thích các folder quan trọng

| Folder | Mục đích |
|--------|---------|
| `app/` | Source code chính (Controllers, Models, Middleware) |
| `routes/` | Định nghĩa các URL routes |
| `resources/views/` | Blade templates (giao diện) |
| `config/` | Cấu hình ứng dụng |
| `database/` | Migrations (schema) và seeders (dữ liệu mẫu) |
| `public/` | Static files, entry point (index.php) |
| `storage/` | Logs, cache, session files (tạo runtime) |

---

## 🛠️ Công nghệ sử dụng

| Công nghệ | Phiên bản | Mục đích |
|-----------|----------|---------|
| **Laravel** | 10.49.1 | Backend framework |
| **PHP** | 8.3.26 | Server-side language |
| **MySQL** | 5.7+ | Database |
| **Tailwind CSS** | 3.3.0 | CSS framework |
| **Blade** | (Laravel) | Template engine |
| **Vite** | 4.3.9 | Build tool |
| **Alpine.js** | 3.12.0 | Lightweight JS |
| **Axios** | 1.4.0 | HTTP client |
| **Composer** | 2.8.4 | PHP package manager |
| **NPM** | 11.3.0 | Node package manager |

---

## 📖 Hướng dẫn sử dụng

### 🏠 Trang chủ
- Truy cập `http://127.0.0.1:8000/`
- Xem các tính năng nổi bật

### 🛍️ Mua sắm
- **Xem sản phẩm**: `/products`
- **Lọc theo danh mục**: `/products?category=cpu`
- **Tìm kiếm**: `/products?q=RAM`
- **Chi tiết sản phẩm**: `/products/{slug}`

### 🛒 Giỏ hàng
- **Xem giỏ hàng**: `/cart` (cần đăng nhập)
- Giỏ hàng được lưu trong Session

### 👤 Tài khoản Admin

#### Đăng nhập
- Email: `admin@pcparts.local`
- Mật khẩu: `password`

#### Quyền hạn
- Chỉ user có `role = 'admin'` mới có thể vào `/admin`
- Middleware `AdminMiddleware` kiểm tra quyền

#### Quản lý sản phẩm
- **Dashboard**: `/admin`
- **Danh sách sản phẩm**: `/admin/products`
- **Tạo sản phẩm**: `/admin/products/create`
- **Chỉnh sửa**: `/admin/products/{id}/edit`
- **Xóa**: Soft delete (không xóa vĩnh viễn)

### 📝 Các trang thông tin
- **Giới thiệu**: `/about`
- **Liên hệ**: `/contact`
- **Blog**: `/blog`

---

## 🔧 Lệnh hay dùng

```bash
# Tạo model + migration
php artisan make:model Product -m

# Tạo controller
php artisan make:controller ProductController

# Chạy migrations
php artisan migrate

# Rollback migrations
php artisan migrate:rollback

# Seed database
php artisan db:seed

# Xem routes
php artisan route:list

# Tạo cache files
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Clear cache
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

---

## 🔐 Bảo mật

- **CSRF Protection**: Tất cả forms có `@csrf`
- **Authentication**: Middleware `auth` kiểm tra đăng nhập
- **Authorization**: Middleware `admin` kiểm tra role admin
- **Hashed Passwords**: Mật khẩu được hash bằng bcrypt
- **Environment Variables**: Thông tin nhạy cảm trong `.env`

---

## 📈 Kế hoạch phát triển

### Phase 1: Cơ bản (Hoàn thành ✅)
- ✅ Kiến trúc MVC cơ bản
- ✅ Authentication & Authorization
- ✅ CRUD sản phẩm
- ✅ Giỏ hàng
- ✅ Trang thông tin

### Phase 2: Nâng cao (Đang phát triển 🔄)
- 🔄 Thanh toán online (Stripe, PayOS)
- 🔄 Quản lý đơn hàng hoàn chỉnh
- 🔄 Xóa tài khoản người dùng
- 🔄 Wishlist & So sánh sản phẩm

### Phase 3: Tối ưu (Kế hoạch 📋)
- 📋 Cache & pagination thông minh
- 📋 Search nâng cao (full-text search)
- 📋 Email notifications
- 📋 Admin dashboard analytics
- 📋 API RESTful hoàn chỉnh
- 📋 Unit & Feature tests

---

## 🐛 Ghi chú & Troubleshooting

### Lỗi: "SQLSTATE[HY000] [1045] Access denied for user 'root'@'localhost'"
**Giải pháp**: Kiểm tra thông tin database trong `.env` và đảm bảo MySQL đang chạy

### Lỗi: "Class 'Illuminate\Foundation\Application' not found"
**Giải pháp**: Chạy `composer install` và kiểm tra `vendor/autoload.php`

### Lỗi: "View not found"
**Giải pháp**: Kiểm tra file Blade có tồn tại trong `resources/views/` và tên file khớp với route

### Views không load CSS Tailwind
**Giải pháp**: Chạy `npm run dev` hoặc sử dụng CDN (đã thêm trong layout)

---

## 👥 Đóng góp

Để đóng góp vào project:

1. Fork repository
2. Tạo branch mới: `git checkout -b feature/your-feature`
3. Commit changes: `git commit -m "Add your feature"`
4. Push to branch: `git push origin feature/your-feature`
5. Mở Pull Request

---

## 📄 License

MIT License - Tự do sử dụng cho mục đích học tập và thương mại

---

## 📞 Liên hệ & Hỗ trợ

Nếu có bất kỳ câu hỏi hoặc vấn đề, vui lòng:
- Mở Issue trên GitHub
- Gửi email: `support@pcparts.vn`
- Tham gia Discord community

---

**Happy coding! 🚀**
