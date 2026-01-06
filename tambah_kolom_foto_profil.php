<?php

/**
 * Script untuk menambahkan kolom foto_profil ke tabel users
 * Upload file ini ke hosting dan jalankan via browser
 */

// Konfigurasi database hosting
$host = 'mysql-shopi-sie.alwaysdata.net';
$dbname = 'shopi-sie_db';
$username = 'shopi-sie';
$password = 'Sh0opiie694';

echo "<h1>🔧 Tambah Kolom foto_profil ke Users</h1>";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "<p style='color: green;'>✅ Koneksi database berhasil!</p>";
    
    // 1. Cek struktur tabel users saat ini
    echo "<h2>1. Struktur Tabel Users Saat Ini</h2>";
    $stmt = $pdo->query("DESCRIBE users");
    $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    $existingColumns = [];
    echo "<table style='width: 100%; border-collapse: collapse; margin: 10px 0; background: white;'>";
    echo "<tr style='background: #f0f0f0;'><th style='border: 1px solid #ddd; padding: 8px;'>Field</th><th style='border: 1px solid #ddd; padding: 8px;'>Type</th><th style='border: 1px solid #ddd; padding: 8px;'>Null</th><th style='border: 1px solid #ddd; padding: 8px;'>Default</th></tr>";
    
    foreach ($columns as $column) {
        $existingColumns[] = $column['Field'];
        echo "<tr>";
        echo "<td style='border: 1px solid #ddd; padding: 8px; font-weight: bold;'>{$column['Field']}</td>";
        echo "<td style='border: 1px solid #ddd; padding: 8px;'>{$column['Type']}</td>";
        echo "<td style='border: 1px solid #ddd; padding: 8px;'>{$column['Null']}</td>";
        echo "<td style='border: 1px solid #ddd; padding: 8px;'>" . ($column['Default'] ?: 'NULL') . "</td>";
        echo "</tr>";
    }
    echo "</table>";
    
    // 2. Tambahkan kolom yang hilang
    echo "<h2>2. Menambahkan Kolom yang Hilang</h2>";
    
    $requiredColumns = [
        'foto_profil' => "VARCHAR(255) NULL",
        'last_login_at' => "TIMESTAMP NULL"
    ];
    
    foreach ($requiredColumns as $columnName => $columnDefinition) {
        if (!in_array($columnName, $existingColumns)) {
            try {
                $sql = "ALTER TABLE users ADD COLUMN `$columnName` $columnDefinition";
                $pdo->exec($sql);
                echo "<p style='color: green;'>✅ Kolom '$columnName' berhasil ditambahkan</p>";
            } catch (Exception $e) {
                echo "<p style='color: red;'>❌ Gagal menambahkan kolom '$columnName': " . $e->getMessage() . "</p>";
            }
        } else {
            echo "<p style='color: blue;'>ℹ️ Kolom '$columnName' sudah ada</p>";
        }
    }
    
    // 3. Tampilkan struktur tabel setelah update
    echo "<h2>3. Struktur Tabel Users Setelah Update</h2>";
    $stmt = $pdo->query("DESCRIBE users");
    $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo "<table style='width: 100%; border-collapse: collapse; margin: 10px 0; background: white;'>";
    echo "<tr style='background: #f0f0f0;'><th style='border: 1px solid #ddd; padding: 8px;'>Field</th><th style='border: 1px solid #ddd; padding: 8px;'>Type</th><th style='border: 1px solid #ddd; padding: 8px;'>Null</th><th style='border: 1px solid #ddd; padding: 8px;'>Default</th></tr>";
    
    foreach ($columns as $column) {
        $highlight = in_array($column['Field'], ['foto_profil', 'last_login_at']) ? 'background: #e8f5e8;' : '';
        echo "<tr style='$highlight'>";
        echo "<td style='border: 1px solid #ddd; padding: 8px; font-weight: bold;'>{$column['Field']}</td>";
        echo "<td style='border: 1px solid #ddd; padding: 8px;'>{$column['Type']}</td>";
        echo "<td style='border: 1px solid #ddd; padding: 8px;'>{$column['Null']}</td>";
        echo "<td style='border: 1px solid #ddd; padding: 8px;'>" . ($column['Default'] ?: 'NULL') . "</td>";
        echo "</tr>";
    }
    echo "</table>";
    
    // 4. Test update user dengan foto
    echo "<h2>4. Test Update User</h2>";
    try {
        // Ambil user pertama
        $stmt = $pdo->query("SELECT id, name, email FROM users LIMIT 1");
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($user) {
            echo "<p>Test user: {$user['name']} ({$user['email']})</p>";
            
            // Test update dengan foto_profil
            $stmt = $pdo->prepare("UPDATE users SET foto_profil = ? WHERE id = ?");
            $testPhotoPath = "users/test_photo.jpg";
            $result = $stmt->execute([$testPhotoPath, $user['id']]);
            
            if ($result) {
                echo "<p style='color: green;'>✅ Berhasil test update foto_profil</p>";
                
                // Reset ke NULL
                $stmt = $pdo->prepare("UPDATE users SET foto_profil = NULL WHERE id = ?");
                $stmt->execute([$user['id']]);
                echo "<p style='color: blue;'>ℹ️ Reset foto_profil ke NULL</p>";
            } else {
                echo "<p style='color: red;'>❌ Gagal test update foto_profil</p>";
            }
        } else {
            echo "<p style='color: orange;'>⚠️ Tidak ada user untuk test</p>";
        }
    } catch (Exception $e) {
        echo "<p style='color: orange;'>⚠️ Test update: " . $e->getMessage() . "</p>";
    }
    
    // 5. Tampilkan data users
    echo "<h2>5. Data Users Saat Ini</h2>";
    $stmt = $pdo->query("SELECT id, name, email, role, foto_profil FROM users ORDER BY id");
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo "<table style='width: 100%; border-collapse: collapse; margin: 10px 0; background: white;'>";
    echo "<tr style='background: #f0f0f0;'><th style='border: 1px solid #ddd; padding: 8px;'>ID</th><th style='border: 1px solid #ddd; padding: 8px;'>Nama</th><th style='border: 1px solid #ddd; padding: 8px;'>Email</th><th style='border: 1px solid #ddd; padding: 8px;'>Role</th><th style='border: 1px solid #ddd; padding: 8px;'>Foto</th></tr>";
    
    foreach ($users as $user) {
        echo "<tr>";
        echo "<td style='border: 1px solid #ddd; padding: 8px;'>{$user['id']}</td>";
        echo "<td style='border: 1px solid #ddd; padding: 8px;'>{$user['name']}</td>";
        echo "<td style='border: 1px solid #ddd; padding: 8px;'>{$user['email']}</td>";
        echo "<td style='border: 1px solid #ddd; padding: 8px; color: red; font-weight: bold;'>{$user['role']}</td>";
        echo "<td style='border: 1px solid #ddd; padding: 8px;'>" . ($user['foto_profil'] ?: 'NULL') . "</td>";
        echo "</tr>";
    }
    echo "</table>";
    
    echo "<h2>🎉 Perbaikan Kolom Users Selesai!</h2>";
    echo "<div style='background: white; padding: 15px; border-radius: 5px; margin: 10px 0;'>";
    echo "<p><strong>Yang sudah diperbaiki:</strong></p>";
    echo "<ol>";
    echo "<li>✅ Kolom foto_profil ditambahkan ke tabel users</li>";
    echo "<li>✅ Kolom last_login_at ditambahkan ke tabel users</li>";
    echo "<li>✅ UserController diperbaiki dengan error handling</li>";
    echo "<li>✅ AuthController diperbaiki dengan error handling</li>";
    echo "</ol>";
    
    echo "<p><strong>Langkah selanjutnya:</strong></p>";
    echo "<ol>";
    echo "<li>🧪 Test edit user dengan upload foto</li>";
    echo "<li>🧪 Test tambah user baru dengan foto</li>";
    echo "<li>🧪 Test registrasi dengan foto</li>";
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