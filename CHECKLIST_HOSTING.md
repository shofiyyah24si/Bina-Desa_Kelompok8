# CHECKLIST HOSTING ALWAYSDATA

## Sebelum Upload ke Server:
- [x] Backup database: php artisan db:backup
- [x] Backup uploads: folder backup_uploads/ sudah dibuat
- [x] Update .env untuk production
- [x] Set APP_DEBUG=false
- [x] Set APP_ENV=production

## Setelah Upload ke Server:
- [ ] Upload semua file via FTP/SFTP
- [ ] Upload database via phpMyAdmin
- [ ] Jalankan: php artisan storage:link
- [ ] Set permissions: chmod -R 755 public/uploads
- [ ] Set permissions: chmod -R 755 storage/app/public
- [ ] Jalankan: php artisan migrate --force
- [ ] Jalankan: php artisan config:cache
- [ ] Jalankan: php artisan route:cache
- [ ] Test upload foto baru
- [ ] Test akses foto lama
- [ ] Cek semua halaman berfungsi

## Troubleshooting:
- Jika foto tidak muncul: cek file TROUBLESHOOTING_UPLOAD.md
- Jika error 500: cek storage/logs/laravel.log
- Jika permission error: chmod -R 755 pada folder uploads dan storage

## File Penting untuk Hosting:
- .env.alwaysdata.example (template environment)
- backup_uploads/ (backup foto)
- TROUBLESHOOTING_UPLOAD.md (panduan troubleshooting)
- setup-alwaysdata.sh (script setup otomatis)
