<?php

/**
 * Script sederhana untuk menambahkan kolom foto ke tabel warga dan users
 * Upload file ini ke hosting dan jalankan via browser
 */

// Konfigurasi database hosting
$host = 'mysql-shopi-sie.alwaysdata.net';
$dbname = 'shopi-sie_db';
$username = 'shopi-sie';
$password = 'Sh0opiie694';

echo "<h1>🔧 Tambah Kolom Foto ke Tabel Warga & Users</h1>";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "<p style='color: green;'>✅ Koneksi database berhasil!</p>";
    
    // 1. Perbaiki tabel warga
    echo "<h2>1. Memperbaiki Tabel Warga</h2>";
    $stmt = $pdo->query("SHOW COLUMNS FROM warga LIKE 'foto_profil'");
    $wargaFotoExists = $stmt->rowCount() > 0;
    
    if (!$wargaFotoExists) {
        $pdo->exec("ALTER TABLE warga ADD COLUMN `foto_profil` VARCHAR(255) NULL COMMENT 'Path foto profil warga'");
        echo "<p style='color: green;'>✅ Kolom 'foto_profil' berhasil ditambahkan ke tabel warga!</p>";
    } else {
        echo "<p style='color: blue;'>ℹ️ Kolom 'foto_profil' sudah ada di tabel warga</p>";
    }
    
    // 2. Perbaiki tabel users
    echo "<h2>2. Memperbaiki Tabel Users</h2>";
    $stmt = $pdo->query("SHOW COLUMNS FROM users LIKE 'foto_profil'");
    $usersFotoExists = $stmt->rowCount() > 0;
    
    if (!$usersFotoExists) {
        $pdo->exec("ALTER TABLE users ADD COLUMN `foto_profil` VARCHAR(255) NULL COMMENT 'Path foto profil user'");
        echo "<p style='color: green;'>✅ Kolom 'foto_profil' berhasil ditambahkan ke tabel users!</p>";
    } else {
        echo "<p style='color: blue;'>ℹ️ Kolom 'foto_profil' sudah ada di tabel users</p>";
    }
    
    // 3. Perbaiki tabel kejadian_bencana
    echo "<h2>3. Memperbaiki Tabel Kejadian Bencana</h2>";
    $stmt = $pdo->query("SHOW COLUMNS FROM kejadian_bencana LIKE 'foto_profil'");
    $kejadianFotoExists = $stmt->rowCount() > 0;
    
    if (!$kejadianFotoExists) {
        $pdo->exec("ALTER TABLE kejadian_bencana ADD COLUMN `foto_profil` VARCHAR(255) NULL COMMENT 'Path foto utama kejadian bencana'");
        echo "<p style='color: green;'>✅ Kolom 'foto_profil' berhasil ditambahkan ke tabel kejadian_bencana!</p>";
    } else {
        echo "<p style='color: blue;'>ℹ️ Kolom 'foto_profil' sudah ada di tabel kejadian_bencana</p>";
    }
    
    // 4. Pastikan folder upload ada
    echo "<h2>4. Membuat Folder Upload</h2>";
    $folders = [
        'uploads' => $_SERVER['DOCUMENT_ROOT'] . '/uploads',
        'uploads/warga' => $_SERVER['DOCUMENT_ROOT'] . '/uploads/warga',
        'uploads/users' => $_SERVER['DOCUMENT_ROOT'] . '/uploads/users',
        'uploads/kejadian_bencana' => $_SERVER['DOCUMENT_ROOT'] . '/uploads/kejadian_bencana'
    ];
    
    foreach ($folders as $name => $path) {
        if (!file_exists($path)) {
            mkdir($path, 0755, true);
            echo "<p style='color: green;'>✅ Folder '$name' dibuat</p>";
            
            // Buat .htaccess untuk keamanan (kecuali folder utama uploads)
            if ($name !== 'uploads') {
                file_put_contents($path . '/.htaccess', "Options -Indexes\n<Files *.php>\nDeny from all\n</Files>");
                echo "<p style='color: green;'>✅ File keamanan .htaccess dibuat di '$name'</p>";
            }
        } else {
            echo "<p style='color: blue;'>ℹ️ Folder '$name' sudah ada</p>";
        }
    }
    
    // 5. Tampilkan struktur tabel sekarang
    echo "<h2>5. Struktur Tabel Sekarang</h2>";
    
    // Tabel warga
    echo "<h3>Tabel Warga:</h3>";
    $stmt = $pdo->query("DESCRIBE warga");
    echo "<table style='width: 100%; border-collapse: collapse; background: white; margin: 10px 0;'>";
    echo "<tr style='background: #f0f0f0;'><th style='border: 1px solid #ddd; padding: 8px;'>Field</th><th style='border: 1px solid #ddd; padding: 8px;'>Type</th><th style='border: 1px solid #ddd; padding: 8px;'>Null</th></tr>";
    
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $highlight = ($row['Field'] === 'foto_profil') ? 'background: #d4edda;' : '';
        echo "<tr style='$highlight'>";
        echo "<td style='border: 1px solid #ddd; padding: 8px; font-weight: bold;'>{$row['Field']}</td>";
        echo "<td style='border: 1px solid #ddd; padding: 8px;'>{$row['Type']}</td>";
        echo "<td style='border: 1px solid #ddd; padding: 8px;'>{$row['Null']}</td>";
        echo "</tr>";
    }
    echo "</table>";
    
    // Tabel users
    echo "<h3>Tabel Users:</h3>";
    $stmt = $pdo->query("DESCRIBE users");
    echo "<table style='width: 100%; border-collapse: collapse; background: white; margin: 10px 0;'>";
    echo "<tr style='background: #f0f0f0;'><th style='border: 1px solid #ddd; padding: 8px;'>Field</th><th style='border: 1px solid #ddd; padding: 8px;'>Type</th><th style='border: 1px solid #ddd; padding: 8px;'>Null</th></tr>";
    
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $highlight = ($row['Field'] === 'foto_profil') ? 'background: #d4edda;' : '';
        echo "<tr style='$highlight'>";
        echo "<td style='border: 1px solid #ddd; padding: 8px; font-weight: bold;'>{$row['Field']}</td>";
        echo "<td style='border: 1px solid #ddd; padding: 8px;'>{$row['Type']}</td>";
        echo "<td style='border: 1px solid #ddd; padding: 8px;'>{$row['Null']}</td>";
        echo "</tr>";
    }
    echo "</table>";
    
    // Tabel kejadian_bencana
    echo "<h3>Tabel Kejadian Bencana:</h3>";
    $stmt = $pdo->query("DESCRIBE kejadian_bencana");
    echo "<table style='width: 100%; border-collapse: collapse; background: white; margin: 10px 0;'>";
    echo "<tr style='background: #f0f0f0;'><th style='border: 1px solid #ddd; padding: 8px;'>Field</th><th style='border: 1px solid #ddd; padding: 8px;'>Type</th><th style='border: 1px solid #ddd; padding: 8px;'>Null</th></tr>";
    
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $highlight = ($row['Field'] === 'foto_profil') ? 'background: #d4edda;' : '';
        echo "<tr style='$highlight'>";
        echo "<td style='border: 1px solid #ddd; padding: 8px; font-weight: bold;'>{$row['Field']}</td>";
        echo "<td style='border: 1px solid #ddd; padding: 8px;'>{$row['Type']}</td>";
        echo "<td style='border: 1px solid #ddd; padding: 8px;'>{$row['Null']}</td>";
        echo "</tr>";
    }
    echo "</table>";
    
    echo "<h2>🎉 Selesai!</h2>";
    echo "<div style='background: white; padding: 15px; border-radius: 5px; margin: 10px 0;'>";
    echo "<p><strong>✅ Yang sudah diperbaiki:</strong></p>";
    echo "<ul>";
    echo "<li>✅ Kolom 'foto_profil' ditambahkan ke tabel warga (sama seperti users)</li>";
    echo "<li>✅ Kolom 'foto_profil' ditambahkan ke tabel users</li>";
    echo "<li>✅ Kolom 'foto_profil' ditambahkan ke tabel kejadian_bencana</li>";
    echo "<li>✅ Folder 'uploads/warga', 'uploads/users', dan 'uploads/kejadian_bencana' sudah dibuat</li>";
    echo "<li>✅ Keamanan folder upload sudah diatur</li>";
    echo "</ul>";
    
    echo "<p><strong>🎯 Sekarang bisa:</strong></p>";
    echo "<ul>";
    echo "<li>�  Edit data warga dengan upload foto → tersimpan di uploads/warga/</li>";
    echo "<li>� Edit data  user dengan upload foto → tersimpan di uploads/users/</li>";
    echo "<li>� UEdit data kejadian bencana dengan upload foto → tersimpan di uploads/kejadian_bencana/</li>";
    echo "<li>📸 Foto akan muncul di halaman index warga, users, dan kejadian bencana</li>";
    echo "<li>🔄 Upload foto baru akan mengganti foto lama</li>";
    echo "<li>✅ Sistem warga, users, dan kejadian bencana sekarang menggunakan mekanisme yang sama persis</li>";
    echo "</ul>";
    
    echo "<p style='color: red;'><strong>⚠️ Jangan lupa hapus file ini setelah selesai!</strong></p>";
    echo "</div>";
    
} catch (PDOException $e) {
    echo "<h2 style='color: red;'>❌ Error Database</h2>";
    echo "<p>Error: " . $e->getMessage() . "</p>";
}

?>

<style>
body {
    font-family: Arial, sans-serif;
    max-width: 1000px;
    margin: 20px auto;
    padding: 20px;
    background: #f5f5f5;
}

h1, h2, h3 {
    color: #333;
}

p, li {
    background: white;
    padding: 10px;
    margin: 5px 0;
    border-radius: 5px;
    border-left: 4px solid #007bff;
}

ul {
    background: white;
    padding: 15px;
    border-radius: 5px;
    margin: 10px 0;
}

table {
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

th {
    background: #007bff;
    color: white;
}
</style>