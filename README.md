# PHÁT TRIỂN ỨNG DỤNG WEB - IS207

<div align="center">

![UITech Logo](public/images/logo/uitech-logo.png)

**UITech Store - Hệ thống E-Commerce bán linh kiện máy tính**

[![Laravel](https://img.shields.io/badge/Laravel-10.49-FF2D20?logo=laravel&logoColor=white)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-8.2+-777BB4?logo=php&logoColor=white)](https://php.net)
[![MySQL](https://img.shields.io/badge/MySQL-8.0-4479A1?logo=mysql&logoColor=white)](https://mysql.com)
[![Docker](https://img.shields.io/badge/Docker-Ready-2496ED?logo=docker&logoColor=white)](https://docker.com)
[![Tailwind CSS](https://img.shields.io/badge/Tailwind-3.3-06B6D4?logo=tailwind-css&logoColor=white)](https://tailwindcss.com)

</div>

---

## 📚 MỤC LỤC

- [🚀 Cài đặt nhanh với Docker](#-cài-đặt-nhanh-với-docker-khuyên-dùng)
- [💻 Cài đặt thủ công](#-cài-đặt-thủ-công)
- [🔐 Tài khoản mặc định](#-tài-khoản-mặc-định)
- [📚 Giới thiệu môn học](#-giới-thiệu-môn-học)
- [✨ Chức năng chính](#-chức-năng-chính)

---

## 🚀 CÀI ĐẶT NHANH VỚI DOCKER (Khuyên dùng)

### Yêu cầu
- [Docker Desktop](https://www.docker.com/products/docker-desktop/) (Windows/Mac) hoặc Docker Engine (Linux)
- Git

### Các bước cài đặt

```powershell
# 1. Clone repository
git clone https://github.com/duckonthemic/IS207_Final.git
cd IS207_Final

# 2. Khởi động Docker containers
docker-compose up -d

# 3. Đợi khoảng 30 giây để khởi tạo database và seed data
# Kiểm tra logs:
docker-compose logs -f app
```

### Truy cập ứng dụng

| Service | URL | Mô tả |
|---------|-----|-------|
| 🌐 **Web App** | http://localhost:8000 | Trang web chính |
| 📊 **phpMyAdmin** | http://localhost:8080 | Quản lý database |
| 🔴 **Redis** | localhost:6379 | Cache & Queue |
| 🐬 **MySQL** | localhost:3307 | Database |

### Các lệnh Docker hữu ích

```powershell
# Xem logs
docker-compose logs -f app

# Dừng containers
docker-compose down

# Rebuild và khởi động lại
docker-compose down && docker-compose build --no-cache && docker-compose up -d

# Chạy artisan command
docker-compose exec app php artisan <command>

# Reset database
docker-compose exec app php artisan migrate:fresh --seed
```

---

## 💻 CÀI ĐẶT THỦ CÔNG

### Yêu cầu hệ thống

| Yêu cầu | Phiên bản | Ghi chú |
|---------|-----------|---------|
| **PHP** | 8.2+ | Với các extension: pdo_mysql, mbstring, exif, pcntl, bcmath, gd, zip |
| **Composer** | 2.x | PHP Package Manager |
| **Node.js** | 18+ | Với npm |
| **MySQL** | 8.0+ | Hoặc MariaDB 10.5+ |
| **Git** | 2.x | Version control |

### Khuyến nghị môi trường phát triển

- **Windows:** [Laragon](https://laragon.org/) (bao gồm PHP, MySQL, Apache)
- **macOS:** [Herd](https://herd.laravel.com/) hoặc [Valet](https://laravel.com/docs/valet)
- **Linux:** LAMP Stack hoặc [Sail](https://laravel.com/docs/sail)

---

### Bước 1: Clone repository

```powershell
git clone https://github.com/duckonthemic/IS207_Final.git
cd IS207_Final
```

### Bước 2: Cài đặt PHP dependencies

```powershell
composer install
```

> **Lỗi?** Nếu gặp lỗi extension, kiểm tra `php.ini` đã bật các extension cần thiết chưa.

### Bước 3: Cài đặt Node.js dependencies

```powershell
npm install
```

### Bước 4: Cấu hình môi trường

```powershell
# Copy file .env
copy .env.example .env

# Tạo application key
php artisan key:generate
```

### Bước 5: Cấu hình Database

1. **Tạo database** trong phpMyAdmin hoặc MySQL CLI:

```sql
CREATE DATABASE uitech_store CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

2. **Cập nhật file `.env`** với thông tin database:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=uitech_store
DB_USERNAME=root
DB_PASSWORD=
```

### Bước 6: Chạy Migrations và Seed Data

```powershell
# Chạy migrations (tạo bảng)
php artisan migrate

# Seed data mẫu
php artisan db:seed

# Hoặc chạy cả 2 cùng lúc
php artisan migrate:fresh --seed
```

### Bước 7: Tạo symbolic link cho storage

```powershell
php artisan storage:link
```

### Bước 8: Build Frontend Assets

```powershell
# Development (với hot reload)
npm run dev

# Hoặc Production build
npm run build
```

### Bước 9: Khởi động ứng dụng

```powershell
php artisan serve
```

🎉 **Truy cập:** http://localhost:8000

---

## 🔐 TÀI KHOẢN MẶC ĐỊNH

| Vai trò | Email | Password |
|---------|-------|----------|
| 👨‍💼 **Admin** | admin@uitech.com | password |
| 👤 **User** | user@uitech.com | password |

---

## 📚 GIỚI THIỆU MÔN HỌC

| Thông tin | Chi tiết |
|-----------|----------|
| **Tên môn học** | Phát triển ứng dụng Web |
| **Mã môn học** | IS207 |
| **Mã lớp** | IS207.P11 |
| **Năm học** | 2024-2025 |
| **Học kỳ** | 1 |
| **Giảng viên** | ThS. Nguyễn Tấn Toàn |

---

## 💡 GIỚI THIỆU ĐỒ ÁN

**UITech Store** là hệ thống thương mại điện tử chuyên cung cấp linh kiện máy tính cao cấp, được xây dựng với Laravel 10 và MySQL. Dự án cung cấp trải nghiệm mua sắm hoàn chỉnh với đầy đủ tính năng từ duyệt sản phẩm, giỏ hàng, thanh toán đến quản trị hệ thống.

### 🎯 Mục tiêu dự án

- Xây dựng website E-Commerce chuyên nghiệp theo mô hình MVC
- Áp dụng kiến thức Laravel Framework vào thực tế
- Triển khai đầy đủ chức năng mua bán trực tuyến
- Tạo hệ thống quản trị hiện đại cho admin
- Tối ưu trải nghiệm người dùng với UI/UX thân thiện

### 🔗 Liên kết

- **Repository:** [github.com/duckonthemic/IS207_Final](https://github.com/duckonthemic/IS207_Final)

---

## 🛠️ CÔNG NGHỆ SỬ DỤNG

| Layer | Công nghệ |
|-------|-----------|
| **Backend** | PHP 8.2+, Laravel 10, Eloquent ORM |
| **Frontend** | Blade, Tailwind CSS 3.3, Alpine.js 3.x |
| **Database** | MySQL 8.0, Redis |
| **DevOps** | Docker, Docker Compose, Nginx |
| **Build Tools** | Vite, npm |

---

## 👥 THÀNH VIÊN NHÓM

| STT | MSSV | Họ và Tên | Vai trò |
|-----|------|-----------|---------|
| 1 | 23520xxx | **Hoàng Bảo Long** | Team Leader, Backend Dev |
| 2 | 23520xxx | **Ngụy Công Vũ Trung** | Backend Developer |
| 3 | 23520xxx | **Lương Tuấn Vỹ** | Frontend Developer |
| 4 | 23520xxx | **Nguyễn Duy Phương** | Database Designer |
| 5 | 23520xxx | **Trần Thanh Huy** | UI/UX Designer |
| 6 | 23520xxx | **Nguyễn Tuấn Minh** | Tester & QA |

---

## ✨ CHỨC NĂNG CHÍNH

### 🛍️ Khu vực Người dùng (User)

#### 📦 Quản lý sản phẩm
- ✅ **Danh sách sản phẩm** - Hiển thị với phân trang (20 sản phẩm/trang)
- ✅ **Tìm kiếm** - Search theo tên, mô tả sản phẩm
- ✅ **Lọc sản phẩm** - Theo danh mục, khoảng giá, brand
- ✅ **Sắp xếp** - Theo giá (tăng/giảm), mới nhất, bán chạy
- ✅ **Chi tiết sản phẩm** - Thông số kỹ thuật, hình ảnh, giá, tồn kho
- ✅ **Thông số kỹ thuật** - Hiển thị specs theo từng loại linh kiện

#### 🛒 Giỏ hàng & Thanh toán
- ✅ **Thêm vào giỏ hàng** - Với số lượng tùy chỉnh
- ✅ **Quản lý giỏ hàng** - Cập nhật số lượng, xóa sản phẩm
- ✅ **Tính tổng tiền** - Real-time, bao gồm VAT
- ✅ **Checkout 3 bước** - Shipping → Payment → Review
- ✅ **Quản lý địa chỉ** - Thêm, sửa, xóa, đặt mặc định
- ✅ **Lịch sử đơn hàng** - Xem tất cả đơn đã đặt
- ✅ **Chi tiết đơn hàng** - Theo dõi trạng thái, sản phẩm, thanh toán
- ✅ **Hủy đơn hàng** - Nếu đơn chưa xử lý

#### 🖥️ Build PC & Cấu hình máy
- ✅ **Build PC tự do** - Chọn từng linh kiện (CPU, GPU, RAM, SSD, PSU, Case, Mainboard)
- ✅ **Tự động tính giá** - Real-time price calculation
- ✅ **Lưu cấu hình** - LocalStorage persistence
- ✅ **Thêm tất cả vào giỏ** - Add all components to cart once
- ✅ **PC Gaming** - 10 cấu hình gaming build sẵn
- ✅ **PC AI Workstation** - 3 cấu hình cho AI/ML
- ✅ **PC Office** - 3 cấu hình văn phòng
- ✅ **PC Design** - 3 cấu hình cho đồ họa/thiết kế

#### 👤 Tài khoản & Xác thực
- ✅ **Đăng ký** - Với email verification
- ✅ **Đăng nhập** - Session-based authentication
- ✅ **Quên mật khẩu** - Password reset via email
- ✅ **Cập nhật profile** - Tên, email, password
- ✅ **Quản lý địa chỉ** - Multiple shipping addresses

---

### 🔐 Khu vực Quản trị (Admin)

#### 📊 Dashboard
- ✅ **Thống kê tổng quan** - Doanh thu, đơn hàng, sản phẩm, users
- ✅ **Biểu đồ doanh thu** - Theo ngày/tháng/năm
- ✅ **Đơn hàng mới** - Realtime notifications
- ✅ **Top sản phẩm** - Best sellers & trending

#### 📦 Quản lý sản phẩm
- ✅ **CRUD sản phẩm** - Create, Read, Update, Delete
- ✅ **Upload hình ảnh** - Multiple images per product
- ✅ **Quản lý specs** - Dynamic specifications by component type
- ✅ **Quản lý tồn kho** - Stock tracking & alerts
- ✅ **Quản lý brand** - Brand management
- ✅ **Component types** - CPU, GPU, RAM, SSD, etc.

#### 📋 Quản lý đơn hàng
- ✅ **Danh sách đơn hàng** - Với filters & search
- ✅ **Chi tiết đơn hàng** - Full order information
- ✅ **Cập nhật trạng thái** - Pending → Processing → Shipping → Completed
- ✅ **Hủy đơn** - Cancel orders with reasons

#### 🗂️ Quản lý danh mục
- ✅ **CRUD categories** - Add, edit, delete categories
- ✅ **Hierarchy support** - Parent-child categories
- ✅ **Sort order** - Custom ordering

---

## 🚀 HƯỚNG DẪN CÀI ĐẶT NHANH

> ⬆️ **Xem phần đầu README để có hướng dẫn cài đặt đầy đủ!**

### ⚡ Tóm tắt lệnh (cho người đã quen)

```powershell
# Docker (nhanh nhất)
docker-compose up -d

# Hoặc thủ công
composer install && npm install
copy .env.example .env
php artisan key:generate
php artisan migrate --seed
npm run build
php artisan serve
```

---

## 📁 CẤU TRÚC DỰ ÁN

> 🏗️ **Chi tiết đầy đủ:** Xem [docs/STRUCTURE.md](docs/STRUCTURE.md)

```
IS207_Final/
├── app/                          # Backend logic (PHP)
│   ├── Http/Controllers/         # 8 controllers
│   ├── Models/                   # 15 Eloquent models
│   └── Http/Middleware/          # Auth, Admin, CORS
├── database/
│   ├── migrations/               # 25+ database tables
│   └── seeders/                  # Sample data generators
├── resources/
│   ├── views/                    # 30+ Blade templates
│   ├── css/app.css               # Tailwind CSS
│   └── js/app.js                 # Alpine.js
├── routes/web.php                # 70+ routes defined
├── public/                       # Static assets, images
└── docs/                         # Documentation
    ├── INSTALLATION.md           # Hướng dẫn cài đặt
    ├── STRUCTURE.md              # Cấu trúc chi tiết
    └── TODO_FEATURES.md          # Tính năng & tiến độ
```

### 📊 Thống kê dự án

| Metric | Số lượng |
|--------|----------|
| Controllers | 8 |
| Models | 15 |
| Routes | 70+ |
| Migrations | 25+ |
| Views | 30+ |
| Database Tables | 20+ |
| Seeders | 8 |
| Products (seeded) | 262 |
| Categories | 10 |

---

## 💾 CƠ SỞ DỮ LIỆU

### 📋 Các bảng chính

| Bảng | Mô tả | Quan hệ |
|------|-------|---------|
| `users` | Người dùng (admin/customer) | → carts, orders, addresses |
| `products` | Sản phẩm | → categories, brands, images, specs |
| `categories` | Danh mục | → products |
| `brands` | Thương hiệu | → products |
| `carts` | Giỏ hàng | → users, cart_items |
| `cart_items` | Chi tiết giỏ hàng | → carts, products |
| `orders` | Đơn hàng | → users, order_items |
| `order_items` | Chi tiết đơn hàng | → orders, products |
| `product_images` | Hình ảnh sản phẩm | → products |
| `product_specs` | Thông số kỹ thuật | → products, spec_definitions |
| `spec_definitions` | Định nghĩa specs | → component_types |
| `component_types` | Loại linh kiện (CPU, GPU...) | → products |

> 📊 **ERD Diagram:** Xem [docs/ERD_DIAGRAM.md](docs/ERD_DIAGRAM.md)

---

## 📖 TÀI LIỆU THAM KHẢO

| Tài liệu | Mô tả |
|----------|-------|
| [📥 INSTALLATION.md](docs/INSTALLATION.md) | Hướng dẫn cài đặt chi tiết từng bước |
| [🏗️ STRUCTURE.md](docs/STRUCTURE.md) | Giải thích cấu trúc dự án cho người mới |
| [✅ TODO_FEATURES.md](docs/TODO_FEATURES.md) | Danh sách tính năng & tiến độ |
| [📊 ERD_DIAGRAM.md](docs/ERD_DIAGRAM.md) | Sơ đồ quan hệ database |
| [📈 PROJECT_PROGRESS_REPORT.md](docs/PROJECT_PROGRESS_REPORT.md) | Báo cáo tiến độ dự án |
| [📝 NhiemVu.md](docs/NhiemVu.md) | Phân công công việc |

---

## 🔧 LỆNH HAY DÙNG

### Development

```powershell
php artisan serve              # Chạy server (http://localhost:8000)
npm run dev                    # Watch & compile assets
php artisan tinker             # Laravel REPL console
```

### Database

```powershell
php artisan migrate            # Chạy migrations
php artisan migrate:fresh --seed  # Reset database + seed data
php artisan db:seed            # Chỉ seed data
```

### Cache & Optimization

```powershell
php artisan optimize:clear     # Clear all caches
php artisan config:cache       # Cache config files
php artisan route:cache        # Cache routes
php artisan view:clear         # Clear compiled views
```

### Maintenance

```powershell
composer dump-autoload         # Regenerate autoload
php artisan storage:link       # Link storage to public
```

---

## 🐛 TROUBLESHOOTING

### ❌ Docker: "laravel-worker exited with status 1"
```powershell
# Đảm bảo PHP Redis extension được cài trong Dockerfile
# Kiểm tra logs:
docker-compose logs app
```

### ❌ Lỗi: "SQLSTATE[HY000] [1045] Access denied"
```powershell
# Kiểm tra thông tin database trong .env
DB_HOST=127.0.0.1
DB_DATABASE=uitech_store
DB_USERNAME=root
DB_PASSWORD=

# Đảm bảo MySQL đang chạy
```

### ❌ Lỗi: "Class not found"
```powershell
composer dump-autoload
php artisan optimize:clear
```

### ❌ Assets không load / CSS không hiển thị
```powershell
npm run build
php artisan view:clear
php artisan cache:clear
```

### ❌ Lỗi: "The stream or file could not be opened"
```powershell
# Cấp quyền cho thư mục storage
chmod -R 775 storage bootstrap/cache   # Linux/Mac

# Windows: Click chuột phải → Properties → Security → Edit
```

### ❌ Lỗi: "CSRF token mismatch"
```powershell
php artisan cache:clear
php artisan config:clear
# Xóa cookies trình duyệt và thử lại
```

### ❌ Docker: Port đã được sử dụng
```powershell
# Đổi port trong docker-compose.yml
# Hoặc dừng service đang dùng port đó
netstat -ano | findstr :8000
```

---

## 📄 LICENSE

[MIT License](LICENSE) - Tự do sử dụng cho mục đích học tập và thương mại

---

## 📞 LIÊN HỆ & HỖ TRỢ

- **Email nhóm:** 23520xxx@gm.uit.edu.vn
- **GitHub Issues:** [github.com/duckonthemic/IS207_Final/issues](https://github.com/duckonthemic/IS207_Final/issues)
- **Facebook Group:** [IS207.P11 - Nhóm UITech](https://facebook.com/groups/...)

---

<div align="center">

**Được phát triển với ❤️ bởi Nhóm UITech**

*Đại học Công nghệ Thông tin - ĐHQG TP.HCM*

**⭐ Star dự án nếu bạn thấy hữu ích!**

[🏠 Trang chủ](https://uitech-store.com) • [📖 Docs](docs/) • [🐛 Report Bug](https://github.com/duckonthemic/IS207_Final/issues) • [💡 Request Feature](https://github.com/duckonthemic/IS207_Final/issues)

</div>
