# PC Parts E-Store 🖥️

**Website thương mại điện tử bán linh kiện máy tính** được xây dựng bằng **Laravel 10** + **Tailwind CSS** + **MySQL**. 
Dự án có kiến trúc MVC rõ ràng, hỗ trợ người dùng thường và admin với quyền hạn khác nhau.

---

## 📋 Nội dung

- [Tính năng chính](#-tính-năng-chính)
- [Yêu cầu hệ thống](#-yêu-cầu-hệ-thống)
- [Hướng dẫn cài đặt](#-hướng-dẫn-cài-đặt)
- [Cấu trúc thư mục](#-cấu-trúc-thư-mục)
- [Công nghệ sử dụng](#-công-nghệ-sử-dụng)
- [Hướng dẫn sử dụng](#-hướng-dẫn-sử-dụng)
- [Kế hoạch phát triển](#-kế-hoạch-phát-triển)

---

## ✨ Tính năng chính

### 👥 Khu vực người dùng
- ✅ Trang chủ đẹp với hero section
- ✅ Trang giới thiệu về công ty
- ✅ Trang liên hệ với form
- ✅ Khu blog chia sẻ kinh nghiệm
- ✅ Danh sách sản phẩm với pagination
- ✅ Chi tiết sản phẩm
- ✅ Lọc sản phẩm theo danh mục
- ✅ Tìm kiếm sản phẩm
- ✅ Giỏ hàng (lưu bằng Session)
- ✅ Checkout giả lập

### 🔐 Khu vực Admin (yêu cầu đăng nhập + role admin)
- ✅ Dashboard quản lý
- ✅ CRUD sản phẩm (Create, Read, Update, Delete)
- ✅ Soft delete - khôi phục sản phẩm
- ✅ Quản lý danh mục sản phẩm
- ✅ Thống kê cơ bản

---

## 💻 Yêu cầu hệ thống

- **PHP**: 8.1+
- **Composer**: 2.0+
- **Node.js**: 16.0+ (cho npm)
- **MySQL**: 5.7+
- **Git**: Để clone repository

### Kiểm tra phiên bản
```bash
php -v           # PHP 8.3.26+
composer --version  # Composer 2.8.4+
node --version   # Node v24.1.0+
mysql --version  # MySQL 5.7+
```

---

## 🚀 Hướng dẫn cài đặt

### Bước 1: Clone repository
```bash
git clone https://github.com/duckonthemic/IS207_Final.git
cd IS207_Final
```

### Bước 2: Cài đặt PHP dependencies
```bash
composer install
```

### Bước 3: Cấu hình environment
```bash
cp .env.example .env
php artisan key:generate
```

Sau đó, mở file `.env` và cập nhật thông tin database:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=pc_parts_store
DB_USERNAME=root
DB_PASSWORD=
```

### Bước 4: Cài đặt Node dependencies (Optional - nếu muốn build CSS/JS)
```bash
npm install
npm run dev   # Chạy Vite dev server (hot reload)
# hoặc
npm run build # Build cho production
```

### Bước 5: Tạo database tables
```bash
php artisan migrate
```

### Bước 6: Seed dữ liệu mẫu (Optional)
```bash
php artisan db:seed
```

### Bước 7: Khởi động server
```bash
php artisan serve
```

Server sẽ chạy trên `http://127.0.0.1:8000`

---

## 📁 Cấu trúc thư mục

```
pc-parts-e-store-boilerplate/
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
