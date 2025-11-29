# 🐳 Docker Deployment Guide

## Yêu cầu
- Docker Desktop đã cài đặt
- Ít nhất 4GB RAM cho Docker

## 🚀 Khởi chạy nhanh

### 1. Copy file environment
```bash
cp .env.docker .env
```

### 2. Build và chạy containers
```bash
docker-compose up -d --build
```

### 3. Chờ khoảng 1-2 phút để các service khởi động

### 4. Truy cập ứng dụng
- **Website:** http://localhost:8000
- **phpMyAdmin:** http://localhost:8080 (user: root, pass: root)

## 📋 Lệnh thường dùng

### Xem logs
```bash
docker-compose logs -f app
```

### Chạy artisan commands
```bash
docker-compose exec app php artisan migrate
docker-compose exec app php artisan db:seed
docker-compose exec app php artisan tinker
```

### Dừng containers
```bash
docker-compose down
```

### Dừng và xóa data
```bash
docker-compose down -v
```

### Rebuild sau khi thay đổi code
```bash
docker-compose up -d --build app
```

## 🔧 Cấu trúc Services

| Service | Port | Mô tả |
|---------|------|-------|
| app | 8000 | Laravel + Nginx + PHP-FPM |
| db | 3306 | MySQL 8.0 |
| redis | 6379 | Redis Cache |
| phpmyadmin | 8080 | Database GUI |

## ⚠️ Lưu ý

1. Lần đầu chạy có thể mất thời gian để build image
2. Database sẽ tự động được migrate và seed
3. File `.env.docker` chứa cấu hình cho Docker environment
4. Data được persist trong Docker volumes (không mất khi restart)
