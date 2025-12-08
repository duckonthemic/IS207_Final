# UITech Store

<div align="center">

![UITech Logo](public/images/logo/uitech-logo.png)

**Hệ thống E-Commerce bán linh kiện máy tính**

[![Laravel](https://img.shields.io/badge/Laravel-10.49-FF2D20?logo=laravel&logoColor=white)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-8.2+-777BB4?logo=php&logoColor=white)](https://php.net)
[![MySQL](https://img.shields.io/badge/MySQL-8.0-4479A1?logo=mysql&logoColor=white)](https://mysql.com)
[![Docker](https://img.shields.io/badge/Docker-Ready-2496ED?logo=docker&logoColor=white)](https://docker.com)
[![Tailwind CSS](https://img.shields.io/badge/Tailwind-3.3-06B6D4?logo=tailwind-css&logoColor=white)](https://tailwindcss.com)

</div>

## Giới thiệu

UITech Store là hệ thống thương mại điện tử chuyên cung cấp linh kiện máy tính cao cấp. Dự án được xây dựng với Laravel 10, MySQL và Tailwind CSS, cung cấp trải nghiệm mua sắm hoàn chỉnh từ duyệt sản phẩm, giỏ hàng, thanh toán đến quản trị hệ thống.

## Công nghệ sử dụng

| Layer | Công nghệ |
|-------|-----------|
| **Backend** | PHP 8.2+, Laravel 10, Eloquent ORM |
| **Frontend** | Blade, Tailwind CSS 3.3, Alpine.js 3.x |
| **Database** | MySQL 8.0, Redis |
| **DevOps** | Docker, Docker Compose, Nginx |
| **Build Tools** | Vite, npm |

## Cài đặt

### Yêu cầu

- [Docker Desktop](https://www.docker.com/products/docker-desktop/) hoặc Docker Engine
- Git

### Khởi chạy với Docker

```bash
# Clone repository
git clone https://github.com/duckonthemic/IS207_Final.git
cd IS207_Final

# Khởi động containers
docker-compose up -d

# Xem logs
docker-compose logs -f app
```

### Cài đặt thủ công

```bash
# Cài đặt dependencies
composer install
npm install

# Cấu hình môi trường
cp .env.example .env
php artisan key:generate

# Database
php artisan migrate --seed

# Build assets và chạy server
npm run build
php artisan serve
```

## Truy cập

| Service | URL |
|---------|-----|
| Web App | http://localhost:8000 |
| phpMyAdmin | http://localhost:8080 |

### Tài khoản mặc định

| Vai trò | Email | Password |
|---------|-------|----------|
| Admin | admin@uitech.com | password |
| User | user@uitech.com | password |

## Tính năng chính

### Người dùng
- Duyệt sản phẩm với tìm kiếm, lọc và sắp xếp
- Giỏ hàng và thanh toán đa bước
- Build PC tùy chỉnh với tính giá real-time
- Quản lý tài khoản và lịch sử đơn hàng

### Quản trị viên
- Dashboard thống kê doanh thu
- CRUD sản phẩm, danh mục, thương hiệu
- Quản lý đơn hàng và cập nhật trạng thái
- Quản lý người dùng

## Cấu trúc dự án

```
IS207_Final/
├── app/
│   ├── Http/Controllers/
│   └── Models/
├── database/
│   ├── migrations/
│   └── seeders/
├── resources/
│   ├── views/
│   ├── css/
│   └── js/
├── routes/
├── public/
└── docs/
```

## Thành viên nhóm

| STT | MSSV | Họ và Tên | Vai trò |
|-----|------|-----------|---------|
| 1 | 22520807 | Hoàng Bảo Long | Team Leader, Backend Dev |
| 2 | 22521562 | Ngụy Công Vũ Trung | Backend Developer |
| 3 | 22521711 | Lương Tuấn Vỹ | Frontend Developer |
| 4 | 22521165 | Nguyễn Duy Phương | Database Designer |
| 5 | 23520649 | Trần Thanh Huy | UI/UX Designer |
| 6 | 23520959 | Trần Tuấn Minh | Tester & QA |

## Thông tin môn học

- **Môn học:** Phát triển ứng dụng Web (IS207)
- **Lớp:** IS207.Q13
- **Năm học:** 2025-2026, Học kỳ 1
- **Trường:** Đại học Công nghệ Thông tin - ĐHQG TP.HCM

## License

[MIT License](LICENSE)
