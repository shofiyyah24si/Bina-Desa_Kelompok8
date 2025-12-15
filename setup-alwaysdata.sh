#!/bin/bash

echo "=========================================="
echo "SETUP LARAVEL DI ALWAYSDATA"
echo "=========================================="

echo ""
echo "1. Install dependencies..."
composer install --no-dev --optimize-autoloader

echo ""
echo "2. Setup storage link..."
php artisan storage:link

echo ""
echo "3. Clear dan optimize cache..."
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan cache:clear

echo ""
echo "4. Optimize untuk production..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo ""
echo "5. Generate application key (jika diperlukan)..."
php artisan key:generate

echo ""
echo "6. Run migrations..."
php artisan migrate --force

echo ""
echo "7. Set permissions..."
chmod -R 755 storage
chmod -R 755 bootstrap/cache
chmod -R 755 public/uploads

echo ""
echo "=========================================="
echo "SETUP SELESAI!"
echo "=========================================="
echo ""
echo "Langkah selanjutnya:"
echo "1. Import database backup jika ada"
echo "2. Upload file foto ke public/uploads/"
echo "3. Test aplikasi"
echo ""