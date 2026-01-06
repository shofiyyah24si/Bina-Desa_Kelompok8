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
    
    // 1. Cek apakah kolom foto_profil sudah ada di kejadian_bencana
    echo "<h2>1. Cek Kolom foto_profil di Kejadian Bencana</h2>";
    $stmt = $pdo->query("SHOW COLUMNS FROM kejadian_bencana LIKE 'foto_profil'");
    $kejadianFotoExists = $stmt->rowCount() > 0;
    
    if ($kejadianFotoExists) {
        echo "<p style='color: blue;'>ℹ️ Kolom 'foto_profil' sudah ada di tabel kejadian_bencana</p>";
    } else {
        echo "<p style='color: orange;'>⚠️ Kolom 'foto_profil' belum ada di kejadian_bencana, akan ditambahkan...</p>";
        
        // Tambahkan kolom foto_profil
        $pdo->exec("ALTER TABLE kejadian_bencana ADD COLUMN `foto_profil` VARCHAR(255) NULL COMMENT 'Path foto kejadian bencana'");
        echo "<p style='color: green;'>✅ Kolom 'foto_profil' berhasil ditambahkan ke kejadian_bencana!</p>";
    }
    
    // 2. Cek apakah kolom foto_profil sudah ada di posko_bencana
    echo "<h2>2. Cek Kolom foto_profil di Posko Bencana</h2>";
    $stmt = $pdo->query("SHOW COLUMNS FROM posko_bencana LIKE 'foto_profil'");
    $poskoFotoExists = $stmt->rowCount() > 0;
    
    if ($poskoFotoExists) {
        echo "<p style='color: blue;'>ℹ️ Kolom 'foto_profil' sudah ada di tabel posko_bencana</p>";
    } else {
        echo "<p style='color: orange;'>⚠️ Kolom 'foto_profil' belum ada di posko_bencana, akan ditambahkan...</p>";
        
        // Tambahkan kolom foto_profil
        $pdo->exec("ALTER TABLE posko_bencana ADD COLUMN `foto_profil` VARCHAR(255) NULL COMMENT 'Path foto posko bencana'");
        echo "<p style='color: green;'>✅ Kolom 'foto_profil' berhasil ditambahkan ke posko_bencana!</p>";
    }
    
    // 3. Pastikan folder upload ada
    echo "<h2>3. Cek Folder Upload</h2>";
    $folders = [
        'uploads/kejadian_bencana' => $_SERVER['DOCUMENT_ROOT'] . '/uploads/kejadian_bencana',
        'uploads/posko_bencana' => $_SERVER['DOCUMENT_ROOT'] . '/uploads/posko_bencana'
    ];
    
    foreach ($folders as $name => $path) {
        if (!file_exists($path)) {
            mkdir($path, 0755, true);
            echo "<p style='color: green;'>✅ Folder '$name' dibuat</p>";
            
            // Buat .htaccess untuk keamanan
            file_put_contents($path . '/.htaccess', "Options -Indexes\n<Files *.php>\nDeny from all\n</Files>");
            echo "<p style='color: green;'>✅ File keamanan .htaccess dibuat di '$name'</p>";
        } else {
            echo "<p style='color: blue;'>ℹ️ Folder '$name' sudah ada</p>";
        }
    }
    
    // 4. Test insert data dengan foto
    echo "<h2>4. Test Insert Data</h2>";
    
    // Test kejadian_bencana
    echo "<h3>Test Kejadian Bencana:</h3>";
    $testKejadian = [
        'jenis_bencana' => 'Test Upload Foto Kejadian',
        'tanggal' => date('Y-m-d'),
        'status_kejadian' => 'Dilaporkan',
        'foto_profil' => 'kejadian_bencana/test_photo.jpg'
    ];
    
    $sql = "INSERT INTO kejadian_bencana (jenis_bencana, tanggal, status_kejadian, foto_profil) VALUES (?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$testKejadian['jenis_bencana'], $testKejadian['tanggal'], $testKejadian['status_kejadian'], $testKejadian['foto_profil']]);
    
    $testKejadianId = $pdo->lastInsertId();
    echo "<p style='color: green;'>✅ Test kejadian berhasil diinsert dengan ID: $testKejadianId</p>";
    
    // Test posko_bencana
    echo "<h3>Test Posko Bencana:</h3>";
    $testPosko = [
        'kejadian_id' => $testKejadianId,
        'nama' => 'Test Upload Foto Posko',
        'foto_profil' => 'posko_bencana/test_photo.jpg'
    ];
    
    $sql = "INSERT INTO posko_bencana (kejadian_id, nama, foto_profil) VALUES (?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$testPosko['kejadian_id'], $testPosko['nama'], $testPosko['foto_profil']]);
    
    $testPoskoId = $pdo->lastInsertId();
    echo "<p style='color: green;'>✅ Test posko berhasil diinsert dengan ID: $testPoskoId</p>";
    
    // 5. Cek data yang baru diinsert
    echo "<h2>5. Cek Data Test</h2>";
    
    echo "<h3>Data Kejadian Test:</h3>";
    $stmt = $pdo->prepare("SELECT * FROM kejadian_bencana WHERE kejadian_id = ?");
    $stmt->execute([$testKejadianId]);
    $testKejadianRecord = $stmt->fetch(PDO::FETCH_ASSOC);
    
    echo "<p>Data kejadian yang tersimpan:</p>";
    echo "<ul>";
    echo "<li>ID: {$testKejadianRecord['kejadian_id']}</li>";
    echo "<li>Jenis Bencana: {$testKejadianRecord['jenis_bencana']}</li>";
    echo "<li><strong>Foto Profil: {$testKejadianRecord['foto_profil']}</strong></li>";
    echo "</ul>";
    
    echo "<h3>Data Posko Test:</h3>";
    $stmt = $pdo->prepare("SELECT * FROM posko_bencana WHERE posko_id = ?");
    $stmt->execute([$testPoskoId]);
    $testPoskoRecord = $stmt->fetch(PDO::FETCH_ASSOC);
    
    echo "<p>Data posko yang tersimpan:</p>";
    echo "<ul>";
    echo "<li>ID: {$testPoskoRecord['posko_id']}</li>";
    echo "<li>Nama: {$testPoskoRecord['nama']}</li>";
    echo "<li><strong>Foto Profil: {$testPoskoRecord['foto_profil']}</strong></li>";
    echo "</ul>";
    
    // 6. Cleanup test data
    echo "<h2>6. Cleanup</h2>";
    $stmt = $pdo->prepare("DELETE FROM posko_bencana WHERE posko_id = ?");
    $stmt->execute([$testPoskoId]);
    echo "<p style='color: green;'>✅ Test posko berhasil dihapus</p>";
    
    $stmt = $pdo->prepare("DELETE FROM kejadian_bencana WHERE kejadian_id = ?");
    $stmt->execute([$testKejadianId]);
    echo "<p style='color: green;'>✅ Test kejadian berhasil dihapus</p>";
    
    // 7. Tampilkan struktur tabel final
    echo "<h2>7. Struktur Tabel Final</h2>";
    
    echo "<h3>Tabel kejadian_bencana:</h3>";
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
    
    echo "<h3>Tabel posko_bencana:</h3>";
    $stmt = $pdo->query("DESCRIBE posko_bencana");
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
    echo "<li>✅ Kolom 'foto_profil' ditambahkan ke tabel posko_bencana</li>";
    echo "<li>✅ Folder 'uploads/kejadian_bencana' dan 'uploads/posko_bencana' sudah dibuat</li>";
    echo "<li>✅ Keamanan folder upload sudah diatur</li>";
    echo "<li>✅ Test insert data dengan foto berhasil untuk kedua tabel</li>";
    echo "</ul>";
    
    echo "<p><strong>🎯 Sekarang coba:</strong></p>";
    echo "<ol>";
    echo "<li>Buka halaman tambah kejadian bencana</li>";
    echo "<li>Upload foto dan simpan</li>";
    echo "<li>Cek apakah foto muncul di halaman index kejadian</li>";
    echo "<li>Buka halaman tambah posko bencana</li>";
    echo "<li>Upload foto dan simpan</li>";
    echo "<li>Cek apakah foto muncul di halaman index posko</li>";
    echo "<li>Coba edit kejadian dan posko, ganti foto</li>";
    echo "</ol>";
    
    echo "<p><strong>📋 Mekanisme yang sama dengan User & Warga:</strong></p>";
    echo "<ul>";
    echo "<li>✅ Kolom database: foto_profil</li>";
    echo "<li>✅ Folder upload: uploads/kejadian_bencana/ dan uploads/posko_bencana/</li>";
    echo "<li>✅ URL foto: asset('uploads/' . \$model->foto_profil)</li>";
    echo "<li>✅ Controller logic: sama persis dengan UserController & WargaController</li>";
    echo "<li>✅ Semua modul (User, Warga, Kejadian, Posko) sekarang menggunakan sistem yang identik</li>";
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