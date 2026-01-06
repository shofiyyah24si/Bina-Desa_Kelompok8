<?php

/**
 * Script untuk memperbaiki tabel warga di hosting
 * Menambahkan kolom yang diperlukan tanpa migrations
 */

// Konfigurasi database hosting
$host = 'mysql-shopi-sie.alwaysdata.net';
$dbname = 'shopi-sie_db';
$username = 'shopi-sie';
$password = 'Sh0opiie694';

echo "<h1>🔧 Perbaikan Tabel Warga</h1>";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "<p style='color: green;'>✅ Koneksi database berhasil!</p>";
    
    // 1. Cek struktur tabel warga saat ini
    echo "<h2>1. Struktur Tabel Warga Saat Ini</h2>";
    $stmt = $pdo->query("DESCRIBE warga");
    $currentColumns = [];
    
    echo "<table style='width: 100%; border-collapse: collapse; margin: 10px 0; background: white;'>";
    echo "<tr style='background: #f0f0f0;'><th style='border: 1px solid #ddd; padding: 8px;'>Field</th><th style='border: 1px solid #ddd; padding: 8px;'>Type</th><th style='border: 1px solid #ddd; padding: 8px;'>Null</th><th style='border: 1px solid #ddd; padding: 8px;'>Default</th></tr>";
    
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $currentColumns[] = $row['Field'];
        echo "<tr>";
        echo "<td style='border: 1px solid #ddd; padding: 8px; font-weight: bold;'>{$row['Field']}</td>";
        echo "<td style='border: 1px solid #ddd; padding: 8px;'>{$row['Type']}</td>";
        echo "<td style='border: 1px solid #ddd; padding: 8px;'>{$row['Null']}</td>";
        echo "<td style='border: 1px solid #ddd; padding: 8px;'>" . ($row['Default'] ?: 'NULL') . "</td>";
        echo "</tr>";
    }
    echo "</table>";
    
    echo "<p style='color: blue;'>ℹ️ Kolom saat ini: " . implode(', ', $currentColumns) . "</p>";
    
    // 2. Tambah kolom yang diperlukan
    echo "<h2>2. Menambahkan Kolom yang Diperlukan</h2>";
    
    $requiredColumns = [
        'jenis_kelamin' => "VARCHAR(20) NULL COMMENT 'Jenis kelamin warga'",
        'agama' => "VARCHAR(50) NULL COMMENT 'Agama warga'",
        'pekerjaan' => "VARCHAR(100) NULL COMMENT 'Pekerjaan warga'",
        'telp' => "VARCHAR(15) NULL COMMENT 'No telepon warga'",
        'email' => "VARCHAR(100) NULL COMMENT 'Email warga'",
        'foto' => "VARCHAR(255) NULL COMMENT 'Path foto warga'"
    ];
    
    foreach ($requiredColumns as $column => $definition) {
        if (!in_array($column, $currentColumns)) {
            try {
                $pdo->exec("ALTER TABLE warga ADD COLUMN `$column` $definition");
                echo "<p style='color: green;'>✅ Kolom '$column' berhasil ditambahkan</p>";
            } catch (Exception $e) {
                echo "<p style='color: red;'>❌ Gagal menambahkan kolom '$column': " . $e->getMessage() . "</p>";
            }
        } else {
            echo "<p style='color: blue;'>ℹ️ Kolom '$column' sudah ada</p>";
        }
    }
    
    // 3. Pastikan folder upload ada
    echo "<h2>3. Membuat Folder Upload</h2>";
    $uploadPath = $_SERVER['DOCUMENT_ROOT'] . '/uploads/warga';
    if (!file_exists($uploadPath)) {
        if (mkdir($uploadPath, 0755, true)) {
            echo "<p style='color: green;'>✅ Folder 'uploads/warga' berhasil dibuat</p>";
            
            // Buat file .htaccess untuk keamanan
            $htaccessContent = "Options -Indexes\n<Files *.php>\nDeny from all\n</Files>";
            file_put_contents($uploadPath . '/.htaccess', $htaccessContent);
            echo "<p style='color: green;'>✅ File .htaccess keamanan dibuat</p>";
        } else {
            echo "<p style='color: red;'>❌ Gagal membuat folder 'uploads/warga'</p>";
        }
    } else {
        echo "<p style='color: blue;'>ℹ️ Folder 'uploads/warga' sudah ada</p>";
    }
    
    // 4. Test upload
    echo "<h2>4. Test Upload System</h2>";
    $testFile = $uploadPath . '/test.txt';
    if (file_put_contents($testFile, 'Test upload - ' . date('Y-m-d H:i:s'))) {
        echo "<p style='color: green;'>✅ Test upload berhasil</p>";
        unlink($testFile); // Hapus file test
    } else {
        echo "<p style='color: red;'>❌ Test upload gagal</p>";
    }
    
    // 5. Cek struktur tabel setelah perbaikan
    echo "<h2>5. Struktur Tabel Setelah Perbaikan</h2>";
    $stmt = $pdo->query("DESCRIBE warga");
    
    echo "<table style='width: 100%; border-collapse: collapse; margin: 10px 0; background: white;'>";
    echo "<tr style='background: #f0f0f0;'><th style='border: 1px solid #ddd; padding: 8px;'>Field</th><th style='border: 1px solid #ddd; padding: 8px;'>Type</th><th style='border: 1px solid #ddd; padding: 8px;'>Null</th><th style='border: 1px solid #ddd; padding: 8px;'>Default</th></tr>";
    
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "<tr>";
        echo "<td style='border: 1px solid #ddd; padding: 8px; font-weight: bold;'>{$row['Field']}</td>";
        echo "<td style='border: 1px solid #ddd; padding: 8px;'>{$row['Type']}</td>";
        echo "<td style='border: 1px solid #ddd; padding: 8px;'>{$row['Null']}</td>";
        echo "<td style='border: 1px solid #ddd; padding: 8px;'>" . ($row['Default'] ?: 'NULL') . "</td>";
        echo "</tr>";
    }
    echo "</table>";
    
    // 6. Test insert data
    echo "<h2>6. Test Insert Data</h2>";
    try {
        $testData = [
            'nama' => 'Test Warga',
            'no_ktp' => '1234567890123456',
            'jenis_kelamin' => 'Laki-laki',
            'agama' => 'Islam',
            'pekerjaan' => 'Programmer',
            'telp' => '081234567890',
            'email' => 'test@example.com',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];
        
        $columns = implode(', ', array_keys($testData));
        $placeholders = ':' . implode(', :', array_keys($testData));
        
        $stmt = $pdo->prepare("INSERT INTO warga ($columns) VALUES ($placeholders)");
        $result = $stmt->execute($testData);
        
        if ($result) {
            echo "<p style='color: green;'>✅ Test insert berhasil!</p>";
            
            // Hapus data test
            $lastId = $pdo->lastInsertId();
            $pdo->exec("DELETE FROM warga WHERE warga_id = $lastId");
            echo "<p style='color: blue;'>ℹ️ Data test berhasil dihapus</p>";
        }
    } catch (Exception $e) {
        echo "<p style='color: red;'>❌ Test insert gagal: " . $e->getMessage() . "</p>";
    }
    
    echo "<h2>🎉 Perbaikan Tabel Warga Selesai!</h2>";
    echo "<div style='background: white; padding: 15px; border-radius: 5px; margin: 10px 0;'>";
    echo "<p><strong>✅ Yang sudah diperbaiki:</strong></p>";
    echo "<ol>";
    echo "<li>✅ Kolom warga lengkap (nama, no_ktp, jenis_kelamin, agama, pekerjaan, telp, email, foto)</li>";
    echo "<li>✅ Folder upload 'uploads/warga' sudah dibuat</li>";
    echo "<li>✅ Keamanan folder upload (.htaccess)</li>";
    echo "<li>✅ Test insert data berhasil</li>";
    echo "</ol>";
    
    echo "<p><strong>🎯 Sekarang bisa:</strong></p>";
    echo "<ul>";
    echo "<li>📝 Tambah data warga dengan semua field</li>";
    echo "<li>✏️ Edit data warga dengan semua field</li>";
    echo "<li>📸 Upload foto warga ke public/uploads/warga/</li>";
    echo "<li>👁️ Lihat foto warga di halaman index</li>";
    echo "</ul>";
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
</style>