-- Script SQL untuk menambahkan kolom role ke tabel users
-- Jalankan di phpMyAdmin hosting

-- Cek apakah kolom role sudah ada
SELECT COLUMN_NAME 
FROM INFORMATION_SCHEMA.COLUMNS 
WHERE TABLE_NAME = 'users' 
AND TABLE_SCHEMA = 'shopi-sie_db' 
AND COLUMN_NAME = 'role';

-- Jika kolom role belum ada, jalankan query ini:
ALTER TABLE `users` 
ADD COLUMN `role` VARCHAR(50) DEFAULT 'Warga' 
AFTER `email`;

-- Verifikasi struktur tabel
DESCRIBE `users`;