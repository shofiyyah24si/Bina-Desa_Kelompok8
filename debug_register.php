<?php

/**
 * Debug script untuk test registrasi
 * Upload file ini ke hosting dan jalankan via browser
 */

// Konfigurasi database hosting
$host = 'mysql-shopi-sie.alwaysdata.net';
$dbname = 'shopi-sie_db';
$username = 'shopi-sie';
$password = 'Sh0opiie694';

echo "<h1>🔍 Debug Registrasi</h1>";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "<p style='color: green;'>✅ Koneksi database berhasil!</p>";
    
    // 1. Cek struktur tabel users
    echo "<h2>1. Struktur Tabel Users</h2>";
    $stmt = $pdo->query("DESCRIBE users");
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
    
    // 2. Test insert user manual
    echo "<h2>2. Test Insert User Manual</h2>";
    
    $testEmail = 'test_' . time() . '@gmail.com';
    $testName = 'Test User ' . time();
    $testPassword = password_hash('123456', PASSWORD_DEFAULT);
    
    try {
        $stmt = $pdo->prepare("INSERT INTO users (name, email, password, role, created_at, updated_at) VALUES (?, ?, ?, 'Admin', NOW(), NOW())");
        $result = $stmt->execute([$testName, $testEmail, $testPassword]);
        
        if ($result) {
            echo "<p style='color: green;'>✅ Berhasil insert user manual!</p>";
            echo "<p>Email: $testEmail</p>";
            echo "<p>Password: 123456</p>";
        } else {
            echo "<p style='color: red;'>❌ Gagal insert user manual</p>";
        }
    } catch (Exception $e) {
        echo "<p style='color: red;'>❌ Error insert user: " . $e->getMessage() . "</p>";
    }
    
    // 3. Tampilkan user terbaru
    echo "<h2>3. User Terbaru</h2>";
    $stmt = $pdo->query("SELECT id, name, email, role, created_at FROM users ORDER BY id DESC LIMIT 5");
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo "<table style='width: 100%; border-collapse: collapse; margin: 10px 0; background: white;'>";
    echo "<tr style='background: #f0f0f0;'><th style='border: 1px solid #ddd; padding: 8px;'>ID</th><th style='border: 1px solid #ddd; padding: 8px;'>Nama</th><th style='border: 1px solid #ddd; padding: 8px;'>Email</th><th style='border: 1px solid #ddd; padding: 8px;'>Role</th><th style='border: 1px solid #ddd; padding: 8px;'>Dibuat</th></tr>";
    
    foreach ($users as $user) {
        echo "<tr>";
        echo "<td style='border: 1px solid #ddd; padding: 8px;'>{$user['id']}</td>";
        echo "<td style='border: 1px solid #ddd; padding: 8px;'>{$user['name']}</td>";
        echo "<td style='border: 1px solid #ddd; padding: 8px;'>{$user['email']}</td>";
        echo "<td style='border: 1px solid #ddd; padding: 8px; color: red; font-weight: bold;'>{$user['role']}</td>";
        echo "<td style='border: 1px solid #ddd; padding: 8px;'>{$user['created_at']}</td>";
        echo "</tr>";
    }
    echo "</table>";
    
    // 4. Cek apakah ada error di log Laravel
    echo "<h2>4. Informasi Debug</h2>";
    echo "<div style='background: white; padding: 15px; border-radius: 5px; margin: 10px 0;'>";
    echo "<p><strong>Kemungkinan masalah registrasi:</strong></p>";
    echo "<ol>";
    echo "<li>❓ Validasi Laravel gagal</li>";
    echo "<li>❓ Kolom database tidak sesuai</li>";
    echo "<li>❓ Error di AuthController</li>";
    echo "<li>❓ Session atau CSRF token bermasalah</li>";
    echo "</ol>";
    
    echo "<p><strong>Cara test:</strong></p>";
    echo "<ol>";
    echo "<li>🔍 Cek log Laravel di storage/logs/</li>";
    echo "<li>🧪 Coba registrasi dengan data sederhana</li>";
    echo "<li>🔧 Pastikan semua field required ada</li>";
    echo "<li>📝 Cek network tab di browser untuk error</li>";
    echo "</ol>";
    echo "</div>";
    
    echo "<h2>🎯 Test User Berhasil Dibuat!</h2>";
    echo "<p>Silahkan coba login dengan:</p>";
    echo "<p><strong>Email:</strong> $testEmail</p>";
    echo "<p><strong>Password:</strong> 123456</p>";
    
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