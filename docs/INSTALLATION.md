# HƯỚNG DẪN CÀI ĐẶT CHI TIẾT

> 📖 **Tài liệu này:** Hướng dẫn cài đặt từng bước cho Windows, macOS, Linux

---

## 📋 MỤC LỤC

- [Yêu cầu hệ thống](#yêu-cầu-hệ-thống)
- [Cài đặt trên Windows](#cài-đặt-trên-windows-laragon)
- [Cài đặt trên macOS](#cài-đặt-trên-macos)
- [Cài đặt trên Linux](#cài-đặt-trên-linux-ubuntu)
- [Troubleshooting](#troubleshooting)

---

## ⚙️ YÊU CẦU HỆ THỐNG

### Minimum Requirements

| Software | Phiên bản tối thiểu | Khuyến nghị |
|----------|-------------------|------------|
| **PHP** | 8.1+ | 8.3+ |
| **MySQL** | 5.7+ | 8.0+ |
| **Composer** | 2.0+ | 2.8+ |
| **Node.js** (optional) | 16+ | 20+ |
| **RAM** | 2GB | 4GB+ |
| **Disk Space** | 500MB | 1GB+ |

### PHP Extensions (Required)
- ✅ BCMath
- ✅ Ctype
- ✅ Fileinfo
- ✅ JSON
- ✅ Mbstring
- ✅ OpenSSL
- ✅ PDO
- ✅ Tokenizer
- ✅ XML

---

## 🪟 CÀI ĐẶT TRÊN WINDOWS (LARAGON)

### Bước 1: Cài đặt Laragon

1. **Download Laragon:**
   - Truy cập: https://laragon.org/download/
   - Chọn **Laragon Full** (bao gồm PHP, MySQL, Apache)

2. **Cài đặt Laragon:**
   ```
   - Chạy file .exe đã tải
   - Chọn thư mục cài đặt: C:\laragon (khuyến nghị)
   - Chọn "Full Installation"
   - Chờ cài đặt hoàn tất (~5 phút)
   ```

3. **Khởi động Laragon:**
   ```
   - Mở Laragon
   - Click "Start All" (Apache + MySQL)
   - Đợi icon chuyển sang màu xanh
   ```

### Bước 2: Clone Project

```powershell
# Mở Laragon Terminal (Click phải icon Laragon → Terminal)

# Di chuyển đến thư mục www
cd C:\laragon\www

# Clone repository
git clone https://github.com/duckonthemic/IS207_Final.git

# Di chuyển vào project
cd IS207_Final
```

### Bước 3: Cài đặt Dependencies

```powershell
# Cài PHP dependencies
composer install

# Cài Node dependencies (optional - cho asset compilation)
npm install
```

**Lưu ý:** Nếu gặp lỗi `composer not found`, restart Laragon Terminal.

### Bước 4: Setup Environment

```powershell
# Copy file .env
copy .env.example .env

# Generate application key
php artisan key:generate
```

### Bước 5: Tạo Database

**Cách 1: Sử dụng phpMyAdmin**
```
1. Mở trình duyệt: http://localhost/phpmyadmin
2. Username: root
3. Password: (để trống)
4. Click "New" → Tạo database tên "uitech_store"
5. Collation: utf8mb4_unicode_ci
```

**Cách 2: Sử dụng MySQL Command**
```powershell
mysql -u root -p
# Enter password (để trống nếu không có)

CREATE DATABASE uitech_store CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
EXIT;
```

### Bước 6: Cấu hình Database

**Mở file `.env` và sửa:**
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=uitech_store
DB_USERNAME=root
DB_PASSWORD=
```

### Bước 7: Chạy Migrations & Seeders

```powershell
# Tạo tables
php artisan migrate

# Thêm dữ liệu mẫu (262 products, 10 categories, 1000+ images)
php artisan db:seed

# Hoặc chạy cả 2 lệnh
php artisan migrate:fresh --seed
```

**Thời gian chạy seeder:** ~2-3 phút (tùy máy)

### Bước 8: Build Assets (Optional)

```powershell
# Development mode (watch files)
npm run dev

# Production mode (minified)
npm run build
```

**Lưu ý:** Nếu không chạy npm, vẫn có thể dùng Tailwind CSS qua CDN (đã config sẵn).

### Bước 9: Khởi động Server

```powershell
php artisan serve
```

Hoặc để Laragon tự động host:
```
- Laragon sẽ tự tạo virtual host: http://is207_final.test
- Truy cập trực tiếp không cần chạy artisan serve
```

### Bước 10: Truy cập Website

- **Frontend:** http://localhost:8000 (hoặc http://is207_final.test)
- **Admin:** http://localhost:8000/admin/dashboard
- **phpMyAdmin:** http://localhost/phpmyadmin

**Tài khoản admin:**
- Email: `admin@uitech.com`
- Password: `password`

---

## 🍎 CÀI ĐẶT TRÊN macOS

### Bước 1: Cài đặt Homebrew

```bash
/bin/bash -c "$(curl -fsSL https://raw.githubusercontent.com/Homebrew/install/HEAD/install.sh)"
```

### Bước 2: Cài đặt PHP, MySQL, Composer

```bash
# Cài PHP 8.3
brew install php@8.3

# Cài MySQL
brew install mysql

# Start MySQL
brew services start mysql

# Cài Composer
brew install composer

# Cài Node.js (optional)
brew install node
```

### Bước 3: Secure MySQL Installation

```bash
mysql_secure_installation
# Set root password (hoặc để trống)
# Remove anonymous users: Y
# Disallow root login remotely: Y
# Remove test database: Y
# Reload privilege tables: Y
```

### Bước 4: Clone & Setup Project

```bash
# Clone repository
cd ~/Sites  # hoặc thư mục bất kỳ
git clone https://github.com/duckonthemic/IS207_Final.git
cd IS207_Final

# Cài dependencies
composer install
npm install

# Copy .env
cp .env.example .env

# Generate key
php artisan key:generate
```

### Bước 5: Tạo Database

```bash
mysql -u root -p
# Enter password

CREATE DATABASE uitech_store CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
EXIT;
```

### Bước 6: Cấu hình .env

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=uitech_store
DB_USERNAME=root
DB_PASSWORD=your_mysql_password
```

### Bước 7-10: Giống Windows

```bash
php artisan migrate:fresh --seed
npm run build
php artisan serve
```

**Truy cập:** http://localhost:8000

---

## 🐧 CÀI ĐẶT TRÊN LINUX (Ubuntu/Debian)

### Bước 1: Update System

```bash
sudo apt update
sudo apt upgrade -y
```

### Bước 2: Cài đặt PHP 8.3

```bash
# Add PHP repository
sudo add-apt-repository ppa:ondrej/php
sudo apt update

# Cài PHP 8.3 và extensions
sudo apt install -y php8.3 php8.3-cli php8.3-fpm php8.3-mysql \
  php8.3-curl php8.3-xml php8.3-mbstring php8.3-zip \
  php8.3-bcmath php8.3-gd php8.3-intl

# Kiểm tra version
php -v
```

### Bước 3: Cài đặt MySQL

```bash
# Cài MySQL Server
sudo apt install -y mysql-server

# Secure MySQL
sudo mysql_secure_installation

# Khởi động MySQL
sudo systemctl start mysql
sudo systemctl enable mysql
```

### Bước 4: Cài đặt Composer

```bash
# Download Composer
curl -sS https://getcomposer.org/installer | php

# Di chuyển vào /usr/local/bin
sudo mv composer.phar /usr/local/bin/composer

# Kiểm tra
composer --version
```

### Bước 5: Cài đặt Node.js (Optional)

```bash
# Cài Node.js 20.x
curl -fsSL https://deb.nodesource.com/setup_20.x | sudo -E bash -
sudo apt install -y nodejs

# Kiểm tra
node -v
npm -v
```

### Bước 6: Clone Project

```bash
# Clone vào /var/www
cd /var/www
sudo git clone https://github.com/duckonthemic/IS207_Final.git
cd IS207_Final

# Set permissions
sudo chown -R $USER:www-data .
sudo chmod -R 775 storage bootstrap/cache
```

### Bước 7: Cài Dependencies

```bash
composer install
npm install
```

### Bước 8: Setup .env

```bash
cp .env.example .env
php artisan key:generate
```

**Edit `.env`:**
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=uitech_store
DB_USERNAME=root
DB_PASSWORD=your_mysql_password
```

### Bước 9: Tạo Database

```bash
sudo mysql -u root -p
# Enter password

CREATE DATABASE uitech_store CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER 'uitech_user'@'localhost' IDENTIFIED BY 'secure_password';
GRANT ALL PRIVILEGES ON uitech_store.* TO 'uitech_user'@'localhost';
FLUSH PRIVILEGES;
EXIT;
```

**Update `.env` với user mới:**
```env
DB_USERNAME=uitech_user
DB_PASSWORD=secure_password
```

### Bước 10: Migrations & Seeders

```bash
php artisan migrate:fresh --seed
```

### Bước 11: Build Assets

```bash
npm run build
```

### Bước 12: Configure Web Server

**Option A: PHP Built-in Server (Development)**
```bash
php artisan serve --host=0.0.0.0 --port=8000
```

**Option B: Nginx (Production)**

**Tạo file:** `/etc/nginx/sites-available/uitech`
```nginx
server {
    listen 80;
    server_name uitech.local;
    root /var/www/IS207_Final/public;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";

    index index.php;

    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.3-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

**Enable site:**
```bash
sudo ln -s /etc/nginx/sites-available/uitech /etc/nginx/sites-enabled/
sudo nginx -t
sudo systemctl restart nginx
```

**Add to hosts:**
```bash
sudo nano /etc/hosts
# Add line:
127.0.0.1 uitech.local
```

**Truy cập:** http://uitech.local

---

## 🐛 TROUBLESHOOTING

### 1. "composer: command not found"

**Windows:**
```powershell
# Restart Laragon Terminal
# Hoặc thêm Composer vào PATH
```

**Mac/Linux:**
```bash
# Kiểm tra xem composer đã install
which composer

# Nếu chưa có, cài lại
curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer
```

---

### 2. "SQLSTATE[HY000] [1045] Access denied for user 'root'@'localhost'"

**Nguyên nhân:** Sai username/password MySQL

**Giải pháp:**
```powershell
# Kiểm tra MySQL có chạy không
# Windows (Laragon): Click "Start All"
# Mac: brew services list
# Linux: sudo systemctl status mysql

# Kiểm tra thông tin trong .env
DB_USERNAME=root
DB_PASSWORD=
```

---

### 3. "SQLSTATE[42S02]: Base table or view not found"

**Nguyên nhân:** Chưa chạy migrations

**Giải pháp:**
```powershell
php artisan migrate:fresh --seed
```

---

### 4. "Class 'App\Models\Product' not found"

**Nguyên nhân:** Autoload chưa được regenerate

**Giải pháp:**
```powershell
composer dump-autoload
php artisan optimize:clear
```

---

### 5. "The stream or file "storage/logs/laravel.log" could not be opened"

**Nguyên nhân:** Không có quyền ghi vào storage/

**Windows:**
```powershell
# Không cần fix, Laragon tự động set permissions
```

**Mac/Linux:**
```bash
sudo chown -R $USER:www-data storage
sudo chmod -R 775 storage bootstrap/cache
```

---

### 6. "Vite manifest not found"

**Nguyên nhân:** Chưa build assets

**Giải pháp:**
```powershell
npm install
npm run build
```

Hoặc comment dòng Vite trong layout và dùng CDN:
```blade
{{-- @vite(['resources/css/app.css', 'resources/js/app.js']) --}}
<script src="https://cdn.tailwindcss.com"></script>
```

---

### 7. Port 8000 đã được sử dụng

**Giải pháp:**
```powershell
# Dùng port khác
php artisan serve --port=8001

# Hoặc kill process đang dùng port 8000
# Windows:
netstat -ano | findstr :8000
taskkill /PID <PID> /F

# Mac/Linux:
lsof -ti:8000 | xargs kill -9
```

---

### 8. Seeder chạy chậm hoặc timeout

**Nguyên nhân:** Seeding 262 products + 1000+ images mất thời gian

**Giải pháp:**
```powershell
# Tăng max_execution_time trong php.ini
max_execution_time = 300

# Hoặc chạy từng seeder
php artisan db:seed --class=CategorySeeder
php artisan db:seed --class=ComponentTypeSeeder
php artisan db:seed --class=HardwareProductSeeder
```

---

## ✅ KIỂM TRA CÀI ĐẶT

Sau khi cài đặt xong, chạy các test sau:

### 1. Kiểm tra PHP version
```powershell
php -v
# Phải >= 8.1
```

### 2. Kiểm tra database connection
```powershell
php artisan tinker
>>> DB::connection()->getPdo();
# Không có lỗi → OK
```

### 3. Kiểm tra migrations
```powershell
php artisan migrate:status
# Tất cả migrations phải "Ran"
```

### 4. Kiểm tra seeded data
```powershell
php artisan tinker
>>> App\Models\Product::count()
# Phải = 262

>>> App\Models\Category::count()
# Phải = 10

>>> App\Models\User::where('role', 'admin')->first()->email
# Phải = "admin@uitech.com"
```

### 5. Kiểm tra routes
```powershell
php artisan route:list
# Phải có 70+ routes
```

### 6. Truy cập website
```
✅ http://localhost:8000 → Trang chủ
✅ http://localhost:8000/products → Danh sách sản phẩm
✅ http://localhost:8000/admin/dashboard → Admin (sau khi login)
```

---

## 📞 HỖ TRỢ

Nếu gặp vấn đề khác:

1. **Kiểm tra logs:**
   ```
   storage/logs/laravel.log
   ```

2. **Google error message** + "Laravel"

3. **Hỏi trên Discord/Facebook group nhóm**

4. **Tạo GitHub Issue:** https://github.com/duckonthemic/IS207_Final/issues

---

## 📚 TÀI LIỆU THAM KHẢO

- **Laravel Docs:** https://laravel.com/docs/10.x/installation
- **Laragon Docs:** https://laragon.org/docs/
- **Composer:** https://getcomposer.org/doc/
- **Vite:** https://vitejs.dev/guide/

---

**Cập nhật:** 15/11/2025  
**Người viết:** UITech Development Team  
**Version:** 1.0.0
