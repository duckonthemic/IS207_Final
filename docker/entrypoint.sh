#!/bin/bash

echo "🚀 Starting UITech E-Commerce..."

# Wait for database to be ready
echo "⏳ Waiting for database connection..."
while ! php artisan db:monitor --databases=mysql 2>/dev/null; do
    sleep 2
done

echo "✅ Database connected!"

# Run migrations
echo "📦 Running migrations..."
php artisan migrate --force

# Seed database if empty
echo "🌱 Checking if seeding is needed..."
php artisan db:seed --force

# Clear and cache config
echo "⚡ Optimizing application..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Create storage link
php artisan storage:link 2>/dev/null || true

echo "✅ Application is ready!"
echo "🌐 Access at: http://localhost:8000"
echo "📊 phpMyAdmin at: http://localhost:8080"

# Keep container running
exec "$@"
