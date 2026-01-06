<?php

/**
 * Script untuk membuat tabel media yang hilang
 * Upload file ini ke hosting dan jalankan via browser
 */

// Konfigurasi database hosting
$host = 'mysql-shopi-sie.alwaysdata.net';
$dbname = 'shopi-sie_db';
$username = 'shopi-sie';
$password = 'Sh0opiie694';

echo "<h1>🔧 Buat Tabel Media</h1>";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "<p style='color: green;'>✅ Koneksi database berhasil!</p>";
    
    // 1. Cek apakah tabel media sudah ada
    echo "<h2>1. Cek Tabel Media</h2>";
    $stmt = $pdo->query("SHOW TABLES LIKE 'media'");
    $mediaExists = $stmt->rowCount() > 0;
    
    if ($mediaExists) {
        echo "<p style='color: blue;'>ℹ️ Tabel media sudah ada</p>";
    } else {
        echo "<p style='color: orange;'>⚠️ Tabel media tidak ada, akan dibuat</p>";
    }
    
    // 2. Buat tabel media jika belum ada
    if (!$mediaExists) {
        echo "<h2>2. Membuat Tabel Media</h2>";
        
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
        
        try {
            $pdo->exec($sql);
            echo "<p style='color: green;'>✅ Tabel media berhasil dibuat!</p>";
        } catch (Exception $e) {
            echo "<p style='color: red;'>❌ Gagal membuat tabel media: " . $e->getMessage() . "</p>";
        }
    }
    
    // 3. Cek struktur tabel media
    echo "<h2>3. Struktur Tabel Media</h2>";
    try {
        $stmt = $pdo->query("DESCRIBE media");
        $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        echo "<table style='width: 100%; border-collapse: collapse; margin: 10px 0; background: white;'>";
        echo "<tr style='background: #f0f0f0;'><th style='border: 1px solid #ddd; padding: 8px;'>Field</th><th style='border: 1px solid #ddd; padding: 8px;'>Type</th><th style='border: 1px solid #ddd; padding: 8px;'>Null</th><th style='border: 1px solid #ddd; padding: 8px;'>Key</th></tr>";
        
        foreach ($columns as $column) {
            echo "<tr>";
            echo "<td style='border: 1px solid #ddd; padding: 8px; font-weight: bold;'>{$column['Field']}</td>";
            echo "<td style='border: 1px solid #ddd; padding: 8px;'>{$column['Type']}</td>";
            echo "<td style='border: 1px solid #ddd; padding: 8px;'>{$column['Null']}</td>";
            echo "<td style='border: 1px solid #ddd; padding: 8px;'>{$column['Key']}</td>";
            echo "</tr>";
        }
        echo "</table>";
    } catch (Exception $e) {
        echo "<p style='color: red;'>❌ Gagal membaca struktur tabel: " . $e->getMessage() . "</p>";
    }
    
    // 4. Test insert data media
    echo "<h2>4. Test Insert Data Media</h2>";
    try {
        // Cek apakah ada kejadian bencana
        $stmt = $pdo->query("SELECT COUNT(*) FROM kejadian_bencana");
        $kejadianCount = $stmt->fetchColumn();
        
        echo "<p>Jumlah kejadian bencana: $kejadianCount</p>";
        
        if ($kejadianCount > 0) {
            // Ambil kejadian pertama
            $stmt = $pdo->query("SELECT kejadian_id FROM kejadian_bencana LIMIT 1");
            $kejadianId = $stmt->fetchColumn();
            
            // Cek apakah sudah ada media untuk kejadian ini
            $stmt = $pdo->prepare("SELECT COUNT(*) FROM media WHERE ref_table = 'kejadian_bencana' AND ref_id = ?");
            $stmt->execute([$kejadianId]);
            $mediaCount = $stmt->fetchColumn();
            
            if ($mediaCount == 0) {
                // Insert dummy media
                $stmt = $pdo->prepare("INSERT INTO media (ref_table, ref_id, file_url, caption, mime_type, sort_order, created_at, updated_at) VALUES ('kejadian_bencana', ?, 'kejadian_bencana/dummy.jpg', 'Foto dummy', 'image/jpeg', 0, NOW(), NOW())");
                $result = $stmt->execute([$kejadianId]);
                
                if ($result) {
                    echo "<p style='color: green;'>✅ Berhasil insert data media dummy</p>";
                } else {
                    echo "<p style='color: red;'>❌ Gagal insert data media</p>";
                }
            } else {
                echo "<p style='color: blue;'>ℹ️ Media untuk kejadian sudah ada</p>";
            }
        }
    } catch (Exception $e) {
        echo "<p style='color: orange;'>⚠️ Test insert media: " . $e->getMessage() . "</p>";
    }
    
    // 5. Tampilkan data media
    echo "<h2>5. Data Media</h2>";
    try {
        $stmt = $pdo->query("SELECT * FROM media ORDER BY media_id DESC LIMIT 5");
        $mediaData = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        if (count($mediaData) > 0) {
            echo "<table style='width: 100%; border-collapse: collapse; margin: 10px 0; background: white;'>";
            echo "<tr style='background: #f0f0f0;'><th style='border: 1px solid #ddd; padding: 8px;'>ID</th><th style='border: 1px solid #ddd; padding: 8px;'>Ref Table</th><th style='border: 1px solid #ddd; padding: 8px;'>Ref ID</th><th style='border: 1px solid #ddd; padding: 8px;'>File URL</th><th style='border: 1px solid #ddd; padding: 8px;'>Caption</th></tr>";
            
            foreach ($mediaData as $media) {
                echo "<tr>";
                echo "<td style='border: 1px solid #ddd; padding: 8px;'>{$media['media_id']}</td>";
                echo "<td style='border: 1px solid #ddd; padding: 8px;'>{$media['ref_table']}</td>";
                echo "<td style='border: 1px solid #ddd; padding: 8px;'>{$media['ref_id']}</td>";
                echo "<td style='border: 1px solid #ddd; padding: 8px;'>{$media['file_url']}</td>";
                echo "<td style='border: 1px solid #ddd; padding: 8px;'>" . ($media['caption'] ?: 'NULL') . "</td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "<p style='color: blue;'>ℹ️ Belum ada data media</p>";
        }
    } catch (Exception $e) {
        echo "<p style='color: orange;'>⚠️ Gagal membaca data media: " . $e->getMessage() . "</p>";
    }
    
    echo "<h2>🎉 Perbaikan Tabel Media Selesai!</h2>";
    echo "<div style='background: white; padding: 15px; border-radius: 5px; margin: 10px 0;'>";
    echo "<p><strong>Yang sudah diperbaiki:</strong></p>";
    echo "<ol>";
    echo "<li>✅ Tabel media sudah dibuat/dicek</li>";
    echo "<li>✅ Model KejadianBencana diperbaiki</li>";
    echo "<li>✅ Controller diperbaiki dengan error handling</li>";
    echo "</ol>";
    echo "<p><strong>Langkah selanjutnya:</strong></p>";
    echo "<ol>";
    echo "<li>🔄 Refresh halaman kejadian bencana</li>";
    echo "<li>🧪 Test tambah kejadian dengan foto</li>";
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

ol {
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
</style>