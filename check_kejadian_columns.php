<?php

/**
 * Script sederhana untuk mengecek kolom di tabel kejadian_bencana
 * Upload file ini ke hosting dan jalankan via browser
 */

// Konfigurasi database hosting
$host = 'mysql-shopi-sie.alwaysdata.net';
$dbname = 'shopi-sie_db';
$username = 'shopi-sie';
$password = 'Sh0opiie694';

echo "<h1>🔍 Cek Kolom Tabel Kejadian Bencana</h1>";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "<p style='color: green;'>✅ Koneksi database berhasil!</p>";
    
    // Cek struktur tabel kejadian_bencana
    echo "<h2>Struktur Tabel kejadian_bencana:</h2>";
    $stmt = $pdo->query("DESCRIBE kejadian_bencana");
    echo "<table style='width: 100%; border-collapse: collapse; background: white; margin: 10px 0; border: 1px solid #ddd;'>";
    echo "<tr style='background: #f0f0f0;'><th style='border: 1px solid #ddd; padding: 8px;'>Field</th><th style='border: 1px solid #ddd; padding: 8px;'>Type</th><th style='border: 1px solid #ddd; padding: 8px;'>Null</th><th style='border: 1px solid #ddd; padding: 8px;'>Key</th><th style='border: 1px solid #ddd; padding: 8px;'>Default</th></tr>";
    
    $hasFotoProfilColumn = false;
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        if ($row['Field'] === 'foto_profil') {
            $hasFotoProfilColumn = true;
        }
        $highlight = ($row['Field'] === 'foto_profil') ? 'background: #d4edda;' : '';
        echo "<tr style='$highlight'>";
        echo "<td style='border: 1px solid #ddd; padding: 8px; font-weight: bold;'>{$row['Field']}</td>";
        echo "<td style='border: 1px solid #ddd; padding: 8px;'>{$row['Type']}</td>";
        echo "<td style='border: 1px solid #ddd; padding: 8px;'>{$row['Null']}</td>";
        echo "<td style='border: 1px solid #ddd; padding: 8px;'>{$row['Key']}</td>";
        echo "<td style='border: 1px solid #ddd; padding: 8px;'>{$row['Default']}</td>";
        echo "</tr>";
    }
    echo "</table>";
    
    // Status kolom foto_profil
    echo "<h2>Status Kolom foto_profil:</h2>";
    if ($hasFotoProfilColumn) {
        echo "<p style='color: green; background: #d4edda; padding: 15px; border-radius: 5px;'>";
        echo "<strong>✅ KOLOM foto_profil SUDAH ADA!</strong><br>";
        echo "Sistem upload foto kejadian bencana seharusnya sudah bisa berfungsi.";
        echo "</p>";
    } else {
        echo "<p style='color: red; background: #f8d7da; padding: 15px; border-radius: 5px;'>";
        echo "<strong>❌ KOLOM foto_profil BELUM ADA!</strong><br>";
        echo "Anda perlu menjalankan script add_foto_column.php terlebih dahulu untuk menambahkan kolom foto_profil.";
        echo "</p>";
    }
    
    // Cek data sample
    echo "<h2>Sample Data Kejadian Bencana (5 teratas):</h2>";
    $stmt = $pdo->query("SELECT * FROM kejadian_bencana ORDER BY kejadian_id DESC LIMIT 5");
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    if (count($data) > 0) {
        echo "<table style='width: 100%; border-collapse: collapse; background: white; margin: 10px 0; border: 1px solid #ddd;'>";
        echo "<tr style='background: #f0f0f0;'>";
        foreach (array_keys($data[0]) as $column) {
            $highlight = ($column === 'foto_profil') ? 'background: #d4edda;' : '';
            echo "<th style='border: 1px solid #ddd; padding: 8px; $highlight'>$column</th>";
        }
        echo "</tr>";
        
        foreach ($data as $row) {
            echo "<tr>";
            foreach ($row as $key => $value) {
                $highlight = ($key === 'foto_profil') ? 'background: #d4edda;' : '';
                $displayValue = $value ? (strlen($value) > 50 ? substr($value, 0, 50) . '...' : $value) : '-';
                echo "<td style='border: 1px solid #ddd; padding: 8px; $highlight'>$displayValue</td>";
            }
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "<p>Belum ada data kejadian bencana.</p>";
    }
    
    // Instruksi
    echo "<h2>📋 Instruksi:</h2>";
    echo "<div style='background: white; padding: 15px; border-radius: 5px; margin: 10px 0;'>";
    if (!$hasFotoProfilColumn) {
        echo "<p><strong>🔧 Yang perlu dilakukan:</strong></p>";
        echo "<ol>";
        echo "<li>Jalankan script <code>add_foto_column.php</code> untuk menambahkan kolom foto_profil</li>";
        echo "<li>Setelah itu, coba upload foto di form kejadian bencana</li>";
        echo "<li>Jalankan script ini lagi untuk memastikan kolom sudah ditambahkan</li>";
        echo "</ol>";
    } else {
        echo "<p><strong>✅ Kolom foto_profil sudah ada!</strong></p>";
        echo "<p>Sekarang coba:</p>";
        echo "<ol>";
        echo "<li>Buka halaman tambah kejadian bencana</li>";
        echo "<li>Upload foto dan simpan</li>";
        echo "<li>Cek apakah foto muncul di halaman index kejadian</li>";
        echo "<li>Jika masih bermasalah, cek log Laravel di storage/logs/</li>";
        echo "</ol>";
    }
    echo "</div>";
    
    echo "<p style='color: red;'><strong>⚠️ Jangan lupa hapus file ini setelah selesai!</strong></p>";
    
} catch (PDOException $e) {
    echo "<h2 style='color: red;'>❌ Error Database</h2>";
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

code {
    background: #f8f9fa;
    padding: 2px 6px;
    border-radius: 3px;
    font-family: monospace;
}
</style>