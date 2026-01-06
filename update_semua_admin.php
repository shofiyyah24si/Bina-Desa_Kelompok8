<?php

/**
 * Script untuk mengubah semua user menjadi Admin
 * Upload file ini ke hosting dan jalankan via browser
 */

// Konfigurasi database hosting
$host = 'mysql-shopi-sie.alwaysdata.net';
$dbname = 'shopi-sie_db';
$username = 'shopi-sie';
$password = 'Sh0opiie694';

echo "<h1>🔧 Update Semua User Jadi Admin</h1>";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "<p style='color: green;'>✅ Koneksi database berhasil!</p>";
    
    // 1. Tampilkan user sebelum update
    echo "<h2>1. Data User Sebelum Update</h2>";
    $stmt = $pdo->query("SELECT id, name, email, role FROM users ORDER BY id");
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo "<table style='width: 100%; border-collapse: collapse; margin: 10px 0; background: white;'>";
    echo "<tr style='background: #f0f0f0;'><th style='border: 1px solid #ddd; padding: 8px;'>ID</th><th style='border: 1px solid #ddd; padding: 8px;'>Nama</th><th style='border: 1px solid #ddd; padding: 8px;'>Email</th><th style='border: 1px solid #ddd; padding: 8px;'>Role</th></tr>";
    
    foreach ($users as $user) {
        $roleColor = $user['role'] === 'Admin' ? 'color: red; font-weight: bold;' : 'color: blue;';
        echo "<tr>";
        echo "<td style='border: 1px solid #ddd; padding: 8px;'>{$user['id']}</td>";
        echo "<td style='border: 1px solid #ddd; padding: 8px;'>{$user['name']}</td>";
        echo "<td style='border: 1px solid #ddd; padding: 8px;'>{$user['email']}</td>";
        echo "<td style='border: 1px solid #ddd; padding: 8px; $roleColor'>" . ($user['role'] ?: 'KOSONG') . "</td>";
        echo "</tr>";
    }
    echo "</table>";
    
    // 2. Update semua user jadi Admin
    echo "<h2>2. Mengubah Semua User Jadi Admin</h2>";
    
    $stmt = $pdo->prepare("UPDATE users SET role = 'Admin'");
    $result = $stmt->execute();
    $affected = $stmt->rowCount();
    
    if ($result) {
        echo "<p style='color: green;'>✅ Berhasil mengubah $affected user menjadi Admin!</p>";
    } else {
        echo "<p style='color: red;'>❌ Gagal mengubah role user</p>";
    }
    
    // 3. Tampilkan hasil setelah update
    echo "<h2>3. Data User Setelah Update</h2>";
    $stmt = $pdo->query("SELECT id, name, email, role FROM users ORDER BY id");
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo "<table style='width: 100%; border-collapse: collapse; margin: 10px 0; background: white;'>";
    echo "<tr style='background: #f0f0f0;'><th style='border: 1px solid #ddd; padding: 8px;'>ID</th><th style='border: 1px solid #ddd; padding: 8px;'>Nama</th><th style='border: 1px solid #ddd; padding: 8px;'>Email</th><th style='border: 1px solid #ddd; padding: 8px;'>Role</th></tr>";
    
    foreach ($users as $user) {
        echo "<tr>";
        echo "<td style='border: 1px solid #ddd; padding: 8px;'>{$user['id']}</td>";
        echo "<td style='border: 1px solid #ddd; padding: 8px;'>{$user['name']}</td>";
        echo "<td style='border: 1px solid #ddd; padding: 8px;'>{$user['email']}</td>";
        echo "<td style='border: 1px solid #ddd; padding: 8px; color: red; font-weight: bold;'>{$user['role']}</td>";
        echo "</tr>";
    }
    echo "</table>";
    
    echo "<h2>🎉 Update Selesai!</h2>";
    echo "<div style='background: white; padding: 15px; border-radius: 5px; margin: 10px 0;'>";
    echo "<p><strong>Yang sudah diperbaiki:</strong></p>";
    echo "<ol>";
    echo "<li>✅ Semua user sekarang menjadi Admin</li>";
    echo "<li>✅ Form register hanya untuk Admin</li>";
    echo "<li>✅ Form tambah/edit user hanya Admin</li>";
    echo "<li>✅ Upload foto kejadian diperbaiki</li>";
    echo "<li>✅ Middleware role dihapus</li>";
    echo "</ol>";
    echo "<p><strong>Langkah selanjutnya:</strong></p>";
    echo "<ol>";
    echo "<li>🔄 Logout dan login kembali</li>";
    echo "<li>🧪 Test semua fitur (kejadian, user, dll)</li>";
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