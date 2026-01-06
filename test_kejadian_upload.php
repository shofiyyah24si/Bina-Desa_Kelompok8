<?php

/**
 * Script untuk test upload foto kejadian bencana
 * Upload file ini ke hosting dan jalankan via browser
 */

// Konfigurasi database hosting
$host = 'mysql-shopi-sie.alwaysdata.net';
$dbname = 'shopi-sie_db';
$username = 'shopi-sie';
$password = 'Sh0opiie694';

echo "<h1>🧪 Test Upload Foto Kejadian Bencana</h1>";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "<p style='color: green;'>✅ Koneksi database berhasil!</p>";
    
    // Test 1: Cek kolom yang tersedia
    echo "<h2>Test 1: Cek Kolom Database</h2>";
    $availableColumns = [];
    $columns = $pdo->query("SHOW COLUMNS FROM kejadian_bencana")->fetchAll(PDO::FETCH_ASSOC);
    foreach ($columns as $column) {
        $availableColumns[] = $column['Field'];
    }
    
    echo "<p>Kolom yang tersedia: " . implode(', ', $availableColumns) . "</p>";
    
    $hasFotoProfilColumn = in_array('foto_profil', $availableColumns);
    if ($hasFotoProfilColumn) {
        echo "<p style='color: green;'>✅ Kolom foto_profil tersedia</p>";
    } else {
        echo "<p style='color: red;'>❌ Kolom foto_profil TIDAK tersedia - jalankan add_foto_column.php dulu!</p>";
        exit;
    }
    
    // Test 2: Cek folder upload
    echo "<h2>Test 2: Cek Folder Upload</h2>";
    $uploadPath = $_SERVER['DOCUMENT_ROOT'] . '/uploads/kejadian_bencana';
    if (!file_exists($uploadPath)) {
        mkdir($uploadPath, 0755, true);
        echo "<p style='color: green;'>✅ Folder uploads/kejadian_bencana dibuat</p>";
    } else {
        echo "<p style='color: green;'>✅ Folder uploads/kejadian_bencana sudah ada</p>";
    }
    
    // Test 3: Simulasi insert data kejadian dengan foto
    echo "<h2>Test 3: Simulasi Insert Data</h2>";
    
    // Data sample
    $testData = [
        'jenis_bencana' => 'Test Banjir',
        'tanggal' => date('Y-m-d'),
        'lokasi_text' => 'Test Lokasi',
        'rt' => '001',
        'rw' => '002',
        'dampak' => 'Test dampak',
        'status_kejadian' => 'Dilaporkan',
        'keterangan' => 'Test keterangan',
        'foto_profil' => 'kejadian_bencana/test_photo.jpg' // simulasi path foto
    ];
    
    // Filter data berdasarkan kolom yang tersedia
    $filteredData = [];
    foreach ($testData as $field => $value) {
        if (in_array($field, $availableColumns)) {
            $filteredData[$field] = $value;
        }
    }
    
    echo "<p>Data yang akan diinsert: " . implode(', ', array_keys($filteredData)) . "</p>";
    
    // Insert test data
    $placeholders = ':' . implode(', :', array_keys($filteredData));
    $sql = "INSERT INTO kejadian_bencana (" . implode(', ', array_keys($filteredData)) . ") VALUES ($placeholders)";
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute($filteredData);
    
    $testId = $pdo->lastInsertId();
    echo "<p style='color: green;'>✅ Test data berhasil diinsert dengan ID: $testId</p>";
    
    // Test 4: Cek data yang baru diinsert
    echo "<h2>Test 4: Cek Data yang Diinsert</h2>";
    $stmt = $pdo->prepare("SELECT * FROM kejadian_bencana WHERE kejadian_id = ?");
    $stmt->execute([$testId]);
    $insertedData = $stmt->fetch(PDO::FETCH_ASSOC);
    
    echo "<table style='width: 100%; border-collapse: collapse; background: white; margin: 10px 0; border: 1px solid #ddd;'>";
    echo "<tr style='background: #f0f0f0;'><th style='border: 1px solid #ddd; padding: 8px;'>Field</th><th style='border: 1px solid #ddd; padding: 8px;'>Value</th></tr>";
    
    foreach ($insertedData as $field => $value) {
        $highlight = ($field === 'foto_profil') ? 'background: #d4edda;' : '';
        echo "<tr style='$highlight'>";
        echo "<td style='border: 1px solid #ddd; padding: 8px; font-weight: bold;'>$field</td>";
        echo "<td style='border: 1px solid #ddd; padding: 8px;'>$value</td>";
        echo "</tr>";
    }
    echo "</table>";
    
    // Test 5: Test URL foto
    echo "<h2>Test 5: Test URL Foto</h2>";
    if ($insertedData['foto_profil']) {
        $photoUrl = 'https://shopi-sie.alwaysdata.net/uploads/' . $insertedData['foto_profil'];
        echo "<p>URL foto: <a href='$photoUrl' target='_blank'>$photoUrl</a></p>";
        echo "<p>Path foto di server: uploads/{$insertedData['foto_profil']}</p>";
    } else {
        echo "<p>Tidak ada foto tersimpan</p>";
    }
    
    // Cleanup: Hapus test data
    echo "<h2>Cleanup: Hapus Test Data</h2>";
    $stmt = $pdo->prepare("DELETE FROM kejadian_bencana WHERE kejadian_id = ?");
    $stmt->execute([$testId]);
    echo "<p style='color: green;'>✅ Test data berhasil dihapus</p>";
    
    // Kesimpulan
    echo "<h2>📋 Kesimpulan</h2>";
    echo "<div style='background: white; padding: 15px; border-radius: 5px; margin: 10px 0;'>";
    echo "<p><strong>✅ Hasil Test:</strong></p>";
    echo "<ul>";
    echo "<li>✅ Database connection: OK</li>";
    echo "<li>✅ Kolom foto_profil: " . ($hasFotoProfilColumn ? 'ADA' : 'TIDAK ADA') . "</li>";
    echo "<li>✅ Folder upload: OK</li>";
    echo "<li>✅ Insert data dengan foto: OK</li>";
    echo "<li>✅ Retrieve data: OK</li>";
    echo "</ul>";
    
    echo "<p><strong>🎯 Langkah selanjutnya:</strong></p>";
    echo "<ol>";
    echo "<li>Coba buat kejadian bencana baru via form Laravel</li>";
    echo "<li>Upload foto dan simpan</li>";
    echo "<li>Cek apakah foto muncul di halaman index</li>";
    echo "<li>Jika masih bermasalah, cek log Laravel di storage/logs/laravel.log</li>";
    echo "</ol>";
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

a {
    color: #007bff;
    text-decoration: none;
}

a:hover {
    text-decoration: underline;
}
</style>