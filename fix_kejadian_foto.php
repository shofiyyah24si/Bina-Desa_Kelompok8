<?php

/**
 * Script khusus untuk menambahkan kolom foto_profil ke tabel kejadian_bencana
 * Upload file ini ke hosting dan jalankan via browser
 */

// Konfigurasi database hosting
$host = 'mysql-shopi-sie.alwaysdata.net';
$dbname = 'shopi-sie_db';
$username = 'shopi-sie';
$password = 'Sh0opiie694';

echo "<h1>🔧 Fix Foto Kejadian Bencana</h1>";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "<p style='color: green;'>✅ Koneksi database berhasil!</p>";
    
    // 1. Cek apakah kolom foto_profil sudah ada
    echo "<h2>1. Cek Kolom foto_profil</h2>";
    $stmt = $pdo->query("SHOW COLUMNS FROM kejadian_bencana LIKE 'foto_profil'");
    $fotoExists = $stmt->rowCount() > 0;
    
    if ($fotoExists) {
        echo "<p style='color: blue;'>ℹ️ Kolom 'foto_profil' sudah ada di tabel kejadian_bencana</p>";
    } else {
        echo "<p style='color: orange;'>⚠️ Kolom 'foto_profil' belum ada, akan ditambahkan...</p>";
        
        // Tambahkan kolom foto_profil
        $pdo->exec("ALTER TABLE kejadian_bencana ADD COLUMN `foto_profil` VARCHAR(255) NULL COMMENT 'Path foto kejadian bencana'");
        echo "<p style='color: green;'>✅ Kolom 'foto_profil' berhasil ditambahkan!</p>";
    }
    
    // 2. Pastikan folder upload ada
    echo "<h2>2. Cek Folder Upload</h2>";
    $uploadPath = $_SERVER['DOCUMENT_ROOT'] . '/uploads/kejadian_bencana';
    if (!file_exists($uploadPath)) {
        mkdir($uploadPath, 0755, true);
        echo "<p style='color: green;'>✅ Folder 'uploads/kejadian_bencana' dibuat</p>";
        
        // Buat .htaccess untuk keamanan
        file_put_contents($uploadPath . '/.htaccess', "Options -Indexes\n<Files *.php>\nDeny from all\n</Files>");
        echo "<p style='color: green;'>✅ File keamanan .htaccess dibuat</p>";
    } else {
        echo "<p style='color: blue;'>ℹ️ Folder 'uploads/kejadian_bencana' sudah ada</p>";
    }
    
    // 3. Test insert data dengan foto
    echo "<h2>3. Test Insert Data</h2>";
    $testData = [
        'jenis_bencana' => 'Test Upload Foto',
        'tanggal' => date('Y-m-d'),
        'status_kejadian' => 'Dilaporkan',
        'foto_profil' => 'kejadian_bencana/test_photo.jpg'
    ];
    
    $sql = "INSERT INTO kejadian_bencana (jenis_bencana, tanggal, status_kejadian, foto_profil) VALUES (?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$testData['jenis_bencana'], $testData['tanggal'], $testData['status_kejadian'], $testData['foto_profil']]);
    
    $testId = $pdo->lastInsertId();
    echo "<p style='color: green;'>✅ Test data berhasil diinsert dengan ID: $testId</p>";
    
    // 4. Cek data yang baru diinsert
    echo "<h2>4. Cek Data Test</h2>";
    $stmt = $pdo->prepare("SELECT * FROM kejadian_bencana WHERE kejadian_id = ?");
    $stmt->execute([$testId]);
    $testRecord = $stmt->fetch(PDO::FETCH_ASSOC);
    
    echo "<p>Data yang tersimpan:</p>";
    echo "<ul>";
    echo "<li>ID: {$testRecord['kejadian_id']}</li>";
    echo "<li>Jenis Bencana: {$testRecord['jenis_bencana']}</li>";
    echo "<li>Tanggal: {$testRecord['tanggal']}</li>";
    echo "<li>Status: {$testRecord['status_kejadian']}</li>";
    echo "<li><strong>Foto Profil: {$testRecord['foto_profil']}</strong></li>";
    echo "</ul>";
    
    // 5. Cleanup test data
    echo "<h2>5. Cleanup</h2>";
    $stmt = $pdo->prepare("DELETE FROM kejadian_bencana WHERE kejadian_id = ?");
    $stmt->execute([$testId]);
    echo "<p style='color: green;'>✅ Test data berhasil dihapus</p>";
    
    // 6. Tampilkan struktur tabel final
    echo "<h2>6. Struktur Tabel Final</h2>";
    $stmt = $pdo->query("DESCRIBE kejadian_bencana");
    echo "<table style='width: 100%; border-collapse: collapse; background: white; margin: 10px 0; border: 1px solid #ddd;'>";
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
    
    // Kesimpulan
    echo "<h2>🎉 Selesai!</h2>";
    echo "<div style='background: white; padding: 15px; border-radius: 5px; margin: 10px 0;'>";
    echo "<p><strong>✅ Yang sudah diperbaiki:</strong></p>";
    echo "<ul>";
    echo "<li>✅ Kolom 'foto_profil' ditambahkan ke tabel kejadian_bencana</li>";
    echo "<li>✅ Folder 'uploads/kejadian_bencana' sudah dibuat</li>";
    echo "<li>✅ Keamanan folder upload sudah diatur</li>";
    echo "<li>✅ Test insert data dengan foto berhasil</li>";
    echo "</ul>";
    
    echo "<p><strong>🎯 Sekarang coba:</strong></p>";
    echo "<ol>";
    echo "<li>Buka halaman tambah kejadian bencana</li>";
    echo "<li>Upload foto dan simpan</li>";
    echo "<li>Cek apakah foto muncul di halaman index kejadian</li>";
    echo "<li>Coba edit kejadian dan ganti foto</li>";
    echo "</ol>";
    
    echo "<p><strong>📋 Mekanisme yang sama dengan User & Warga:</strong></p>";
    echo "<ul>";
    echo "<li>✅ Kolom database: foto_profil</li>";
    echo "<li>✅ Folder upload: uploads/kejadian_bencana/</li>";
    echo "<li>✅ URL foto: asset('uploads/' . \$kejadian->foto_profil)</li>";
    echo "<li>✅ Controller logic: sama persis dengan UserController & WargaController</li>";
    echo "</ul>";
    echo "</div>";
    
    echo "<p style='color: red;'><strong>⚠️ Jangan lupa hapus file ini setelah selesai!</strong></p>";
    
} catch (Exception $e) {
    echo "<h2 style='color: red;'>❌ Error</h2>";
    echo "<p>Error: " . $e->getMessage() . "</p>";
}

?>

<style>
body {
    font-family: Arial, sans-serif;
    max-width: 1200px;
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

ul, ol {
    background: white;
    padding: 15px;
    border-radius: 5px;
    margin: 10px 0;
}

table {
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    font-size: 12px;
}

th {
    background: #007bff;
    color: white;
}
</style>