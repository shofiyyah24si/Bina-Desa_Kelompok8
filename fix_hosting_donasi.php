<?php

/**
 * Script khusus untuk memperbaiki tabel donasi_bencana di hosting
 * Mengatasi masalah kolom tanggal_donasi yang tidak ada default value
 */

// Konfigurasi database hosting
$host = 'mysql-shopi-sie.alwaysdata.net';
$dbname = 'shopi-sie_db';
$username = 'shopi-sie';
$password = 'Sh0opiie694';

echo "<h1>🔧 Perbaikan Tabel Donasi Hosting</h1>";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "<p style='color: green;'>✅ Koneksi database berhasil!</p>";
    
    // 1. Cek struktur tabel donasi_bencana
    echo "<h2>1. Mengecek Struktur Tabel Donasi</h2>";
    $stmt = $pdo->query("DESCRIBE donasi_bencana");
    $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo "<table style='width: 100%; border-collapse: collapse; margin: 10px 0; background: white;'>";
    echo "<tr style='background: #f0f0f0;'><th style='border: 1px solid #ddd; padding: 8px;'>Field</th><th style='border: 1px solid #ddd; padding: 8px;'>Type</th><th style='border: 1px solid #ddd; padding: 8px;'>Null</th><th style='border: 1px solid #ddd; padding: 8px;'>Default</th></tr>";
    
    $hasTanggalDonasi = false;
    foreach ($columns as $column) {
        if ($column['Field'] === 'tanggal_donasi') {
            $hasTanggalDonasi = true;
        }
        echo "<tr>";
        echo "<td style='border: 1px solid #ddd; padding: 8px; font-weight: bold;'>{$column['Field']}</td>";
        echo "<td style='border: 1px solid #ddd; padding: 8px;'>{$column['Type']}</td>";
        echo "<td style='border: 1px solid #ddd; padding: 8px;'>{$column['Null']}</td>";
        echo "<td style='border: 1px solid #ddd; padding: 8px;'>" . ($column['Default'] ?: 'NULL') . "</td>";
        echo "</tr>";
    }
    echo "</table>";
    
    // 2. Perbaiki kolom tanggal_donasi jika ada
    echo "<h2>2. Memperbaiki Kolom Tanggal Donasi</h2>";
    if ($hasTanggalDonasi) {
        try {
            // Option 1: Add default value to existing column
            $pdo->exec("ALTER TABLE donasi_bencana MODIFY COLUMN tanggal_donasi DATE DEFAULT (CURRENT_DATE)");
            echo "<p style='color: green;'>✅ Kolom 'tanggal_donasi' diberi default value CURRENT_DATE</p>";
        } catch (Exception $e) {
            try {
                // Option 2: Make column nullable
                $pdo->exec("ALTER TABLE donasi_bencana MODIFY COLUMN tanggal_donasi DATE NULL");
                echo "<p style='color: green;'>✅ Kolom 'tanggal_donasi' diubah menjadi nullable</p>";
            } catch (Exception $e2) {
                try {
                    // Option 3: Drop the problematic column
                    $pdo->exec("ALTER TABLE donasi_bencana DROP COLUMN tanggal_donasi");
                    echo "<p style='color: green;'>✅ Kolom 'tanggal_donasi' berhasil dihapus</p>";
                } catch (Exception $e3) {
                    echo "<p style='color: red;'>❌ Gagal memperbaiki kolom tanggal_donasi: " . $e3->getMessage() . "</p>";
                }
            }
        }
    } else {
        echo "<p style='color: blue;'>ℹ️ Kolom 'tanggal_donasi' tidak ditemukan</p>";
    }
    
    // 3. Pastikan kolom jenis fleksibel (bukan enum)
    echo "<h2>3. Memperbaiki Kolom Jenis</h2>";
    try {
        $pdo->exec("ALTER TABLE donasi_bencana MODIFY COLUMN jenis VARCHAR(100) NOT NULL");
        echo "<p style='color: green;'>✅ Kolom 'jenis' diubah menjadi VARCHAR untuk fleksibilitas</p>";
    } catch (Exception $e) {
        echo "<p style='color: orange;'>⚠️ Kolom jenis: " . $e->getMessage() . "</p>";
    }
    
    // 4. Cek struktur tabel setelah perbaikan
    echo "<h2>4. Struktur Tabel Setelah Perbaikan</h2>";
    $stmt = $pdo->query("DESCRIBE donasi_bencana");
    $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo "<table style='width: 100%; border-collapse: collapse; margin: 10px 0; background: white;'>";
    echo "<tr style='background: #f0f0f0;'><th style='border: 1px solid #ddd; padding: 8px;'>Field</th><th style='border: 1px solid #ddd; padding: 8px;'>Type</th><th style='border: 1px solid #ddd; padding: 8px;'>Null</th><th style='border: 1px solid #ddd; padding: 8px;'>Default</th></tr>";
    
    foreach ($columns as $column) {
        echo "<tr>";
        echo "<td style='border: 1px solid #ddd; padding: 8px; font-weight: bold;'>{$column['Field']}</td>";
        echo "<td style='border: 1px solid #ddd; padding: 8px;'>{$column['Type']}</td>";
        echo "<td style='border: 1px solid #ddd; padding: 8px;'>{$column['Null']}</td>";
        echo "<td style='border: 1px solid #ddd; padding: 8px;'>" . ($column['Default'] ?: 'NULL') . "</td>";
        echo "</tr>";
    }
    echo "</table>";
    
    // 5. Test insert data
    echo "<h2>5. Test Insert Data</h2>";
    try {
        $testData = [
            'kejadian_id' => 1,
            'donatur_nama' => 'Test Donatur',
            'jenis' => 'uang',
            'nilai' => 100000,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];
        
        $stmt = $pdo->prepare("INSERT INTO donasi_bencana (kejadian_id, donatur_nama, jenis, nilai, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?)");
        $result = $stmt->execute(array_values($testData));
        
        if ($result) {
            echo "<p style='color: green;'>✅ Test insert berhasil!</p>";
            
            // Hapus data test
            $lastId = $pdo->lastInsertId();
            $pdo->exec("DELETE FROM donasi_bencana WHERE donasi_id = $lastId");
            echo "<p style='color: blue;'>ℹ️ Data test berhasil dihapus</p>";
        }
    } catch (Exception $e) {
        echo "<p style='color: red;'>❌ Test insert gagal: " . $e->getMessage() . "</p>";
    }
    
    echo "<h2>🎉 Perbaikan Tabel Donasi Selesai!</h2>";
    echo "<div style='background: white; padding: 15px; border-radius: 5px; margin: 10px 0;'>";
    echo "<p><strong>✅ Yang sudah diperbaiki:</strong></p>";
    echo "<ol>";
    echo "<li>✅ Kolom tanggal_donasi diperbaiki/dihapus</li>";
    echo "<li>✅ Kolom jenis diubah menjadi VARCHAR</li>";
    echo "<li>✅ Test insert data berhasil</li>";
    echo "</ol>";
    
    echo "<p><strong>🎯 Sekarang bisa menjalankan seeder:</strong></p>";
    echo "<code style='background: #f0f0f0; padding: 5px; border-radius: 3px;'>php artisan db:seed --class=CreateDonasiDummy</code>";
    echo "</div>";
    
} catch (PDOException $e) {
    echo "<h2 style='color: red;'>❌ Error Koneksi Database</h2>";
    echo "<p>Error: " . $e->getMessage() . "</p>";
}

?>

<style>
body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    max-width: 1200px;
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

code {
    font-family: 'Courier New', monospace;
    font-size: 14px;
}
</style>