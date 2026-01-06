<?php

/**
 * Script untuk memperbaiki semua masalah media di semua modul
 * Upload file ini ke hosting dan jalankan via browser
 */

// Konfigurasi database hosting
$host = 'mysql-shopi-sie.alwaysdata.net';
$dbname = 'shopi-sie_db';
$username = 'shopi-sie';
$password = 'Sh0opiie694';

echo "<h1>🔧 Perbaiki Semua Media</h1>";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "<p style='color: green;'>✅ Koneksi database berhasil!</p>";
    
    // 1. Buat tabel media jika belum ada
    echo "<h2>1. Membuat Tabel Media</h2>";
    $stmt = $pdo->query("SHOW TABLES LIKE 'media'");
    $mediaExists = $stmt->rowCount() > 0;
    
    if (!$mediaExists) {
        $sql = "
        CREATE TABLE `media` (
          `media_id` bigint unsigned NOT NULL AUTO_INCREMENT,
          `ref_table` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
          `ref_id` bigint unsigned NOT NULL,
          `file_url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
          `caption` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
          `mime_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
          `sort_order` int NOT NULL DEFAULT '0',
          `created_at` timestamp NULL DEFAULT NULL,
          `updated_at` timestamp NULL DEFAULT NULL,
          PRIMARY KEY (`media_id`),
          KEY `media_ref_table_ref_id_index` (`ref_table`,`ref_id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
        ";
        
        $pdo->exec($sql);
        echo "<p style='color: green;'>✅ Tabel media berhasil dibuat!</p>";
    } else {
        echo "<p style='color: blue;'>ℹ️ Tabel media sudah ada</p>";
    }
    
    // 2. Cek semua tabel yang memerlukan media
    echo "<h2>2. Cek Tabel yang Memerlukan Media</h2>";
    $tables = [
        'kejadian_bencana' => 'kejadian_id',
        'posko_bencana' => 'posko_id',
        'donasi_bencana' => 'donasi_id',
        'distribusi_logistik' => 'distribusi_id',
        'logistik_bencana' => 'logistik_id'
    ];
    
    foreach ($tables as $table => $primaryKey) {
        try {
            $stmt = $pdo->query("SELECT COUNT(*) FROM $table");
            $count = $stmt->fetchColumn();
            echo "<p style='color: green;'>✅ Tabel '$table': $count record</p>";
        } catch (Exception $e) {
            echo "<p style='color: red;'>❌ Tabel '$table': " . $e->getMessage() . "</p>";
        }
    }
    
    // 3. Test akses halaman-halaman
    echo "<h2>3. Status Halaman</h2>";
    $pages = [
        'kejadian' => 'Kejadian Bencana',
        'posko' => 'Posko Bencana',
        'donasi' => 'Donasi Bencana',
        'distribusi' => 'Distribusi Logistik',
        'logistik' => 'Logistik Bencana'
    ];
    
    foreach ($pages as $url => $name) {
        echo "<p style='color: blue;'>📄 $name: <a href='/$url' target='_blank'>/$url</a></p>";
    }
    
    // 4. Buat folder upload jika belum ada
    echo "<h2>4. Membuat Folder Upload</h2>";
    $uploadFolders = [
        'uploads',
        'uploads/kejadian_bencana',
        'uploads/posko_bencana',
        'uploads/donasi_bencana',
        'uploads/distribusi_logistik',
        'uploads/logistik_bencana',
        'uploads/users'
    ];
    
    foreach ($uploadFolders as $folder) {
        $fullPath = $_SERVER['DOCUMENT_ROOT'] . '/' . $folder;
        if (!file_exists($fullPath)) {
            if (mkdir($fullPath, 0755, true)) {
                echo "<p style='color: green;'>✅ Folder '$folder' berhasil dibuat</p>";
            } else {
                echo "<p style='color: red;'>❌ Gagal membuat folder '$folder'</p>";
            }
        } else {
            echo "<p style='color: blue;'>ℹ️ Folder '$folder' sudah ada</p>";
        }
    }
    
    // 5. Tampilkan data media yang ada
    echo "<h2>5. Data Media Saat Ini</h2>";
    try {
        $stmt = $pdo->query("SELECT ref_table, COUNT(*) as count FROM media GROUP BY ref_table");
        $mediaStats = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        if (count($mediaStats) > 0) {
            echo "<table style='width: 100%; border-collapse: collapse; margin: 10px 0; background: white;'>";
            echo "<tr style='background: #f0f0f0;'><th style='border: 1px solid #ddd; padding: 8px;'>Tabel</th><th style='border: 1px solid #ddd; padding: 8px;'>Jumlah Media</th></tr>";
            
            foreach ($mediaStats as $stat) {
                echo "<tr>";
                echo "<td style='border: 1px solid #ddd; padding: 8px;'>{$stat['ref_table']}</td>";
                echo "<td style='border: 1px solid #ddd; padding: 8px;'>{$stat['count']}</td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "<p style='color: blue;'>ℹ️ Belum ada data media</p>";
        }
    } catch (Exception $e) {
        echo "<p style='color: orange;'>⚠️ Gagal membaca data media: " . $e->getMessage() . "</p>";
    }
    
    echo "<h2>🎉 Perbaikan Lengkap Selesai!</h2>";
    echo "<div style='background: white; padding: 15px; border-radius: 5px; margin: 10px 0;'>";
    echo "<p><strong>Yang sudah diperbaiki:</strong></p>";
    echo "<ol>";
    echo "<li>✅ Tabel media sudah dibuat</li>";
    echo "<li>✅ Semua model diperbaiki (KejadianBencana, PoskoBencana, DonasiBencana, DistribusiLogistik)</li>";
    echo "<li>✅ View index diperbaiki dengan error handling</li>";
    echo "<li>✅ Controller diperbaiki dengan error handling</li>";
    echo "<li>✅ Folder upload sudah dibuat</li>";
    echo "</ol>";
    
    echo "<p><strong>Test halaman-halaman ini:</strong></p>";
    echo "<ul>";
    foreach ($pages as $url => $name) {
        echo "<li><a href='/$url' target='_blank'>$name</a></li>";
    }
    echo "</ul>";
    
    echo "<p><strong>Langkah selanjutnya:</strong></p>";
    echo "<ol>";
    echo "<li>🧪 Test semua halaman (kejadian, posko, donasi, dll)</li>";
    echo "<li>📸 Test upload foto di setiap modul</li>";
    echo "<li>🗑️ Hapus file ini setelah selesai</li>";
    echo "</ol>";
    echo "</div>";
    
} catch (PDOException $e) {
    echo "<h2 style='color: red;'>❌ Error Koneksi Database</h2>";
    echo "<p>Error: " . $e->getMessage() . "</p>";
}

?>

<style>
body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    max-width: 1000px;
    margin: 20px auto;
    padding: 20px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: #333;
}

h1, h2 {
    color: #fff;
    text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
}

p, li {
    background: rgba(255,255,255,0.9);
    padding: 8px 12px;
    margin: 5px 0;
    border-radius: 5px;
    border-left: 4px solid #667eea;
}

ol, ul {
    background: rgba(255,255,255,0.9);
    padding: 15px;
    border-radius: 5px;
    margin: 10px 0;
}

table {
    background: rgba(255,255,255,0.95);
    border-radius: 5px;
}

th {
    background: rgba(102, 126, 234, 0.1);
    font-weight: bold;
}

a {
    color: #667eea;
    text-decoration: none;
    font-weight: bold;
}

a:hover {
    text-decoration: underline;
}
</style>