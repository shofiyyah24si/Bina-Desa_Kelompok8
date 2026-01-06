-- Script SQL untuk menambahkan semua kolom yang diperlukan ke tabel users
-- Jalankan di phpMyAdmin hosting

-- Tambahkan kolom role jika belum ada
ALTER TABLE `users` 
ADD COLUMN `role` VARCHAR(50) DEFAULT 'Warga' 
AFTER `email`;

-- Tambahkan kolom foto_profil jika belum ada
ALTER TABLE `users` 
ADD COLUMN `foto_profil` VARCHAR(255) NULL 
AFTER `password`;

-- Tambahkan kolom avatar jika belum ada
ALTER TABLE `users` 
ADD COLUMN `avatar` VARCHAR(255) NULL 
AFTER `foto_profil`;

-- Tambahkan kolom last_login jika belum ada
ALTER TABLE `users` 
ADD COLUMN `last_login` TIMESTAMP NULL 
AFTER `avatar`;

-- Tambahkan kolom last_login_at jika belum ada
ALTER TABLE `users` 
ADD COLUMN `last_login_at` TIMESTAMP NULL 
AFTER `last_login`;

-- Verifikasi struktur tabel
DESCRIBE `users`;

-- Buat user admin default
INSERT IGNORE INTO `users` (name, email, password, role, created_at, updated_at) 
VALUES (
    'Admin', 
    'admin@admin.com', 
    '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 
    'Admin', 
    NOW(), 
    NOW()
);