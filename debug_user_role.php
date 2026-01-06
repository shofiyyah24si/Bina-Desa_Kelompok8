<?php

/**
 * Debug script untuk cek role user di database
 * Upload file ini ke hosting dan jalankan via browser
 */

// Konfigurasi database hosting (SESUAIKAN DENGAN HOSTING KAMU)
$host = 'mysql-shopi-sie.alwaysdata.net'; // sesuaikan dengan hosting
$dbname = 'shopi-sie_db'; // nama database hosting
$username = 'shopi-sie'; // username database hosting  
$password = 'Sh0opiie694'; // password database hosting (sesuaikan)

echo "<h1>🔍 Debug User Role</h1>";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "<p style='color: green;'>✅ Database connection successful!</p>";
    
    // 1. Check table structure
    echo "<h2>1. Users Table Structure</h2>";
    $stmt = $pdo->query("DESCRIBE users");
    $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo "<table style='width: 100%; border-collapse: collapse; margin: 10px 0; background: rgba(255,255,255,0.95);'>";
    echo "<tr style='background: #f0f0f0;'><th style='border: 1px solid #ddd; padding: 8px;'>Field</th><th style='border: 1px solid #ddd; padding: 8px;'>Type</th><th style='border: 1px solid #ddd; padding: 8px;'>Null</th><th style='border: 1px solid #ddd; padding: 8px;'>Key</th><th style='border: 1px solid #ddd; padding: 8px;'>Default</th></tr>";
    
    foreach ($columns as $column) {
        echo "<tr>";
        echo "<td style='border: 1px solid #ddd; padding: 8px; font-weight: bold;'>{$column['Field']}</td>";
        echo "<td style='border: 1px solid #ddd; padding: 8px;'>{$column['Type']}</td>";
        echo "<td style='border: 1px solid #ddd; padding: 8px;'>{$column['Null']}</td>";
        echo "<td style='border: 1px solid #ddd; padding: 8px;'>{$column['Key']}</td>";
        echo "<td style='border: 1px solid #ddd; padding: 8px;'>" . ($column['Default'] ?: 'NULL') . "</td>";
        echo "</tr>";
    }
    echo "</table>";
    
    // 2. Show all users with their actual database values
    echo "<h2>2. All Users (Raw Database Values)</h2>";
    $stmt = $pdo->query("SELECT id, name, email, role, foto_profil, created_at FROM users ORDER BY id DESC");
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo "<table style='width: 100%; border-collapse: collapse; margin: 10px 0; background: rgba(255,255,255,0.95);'>";
    echo "<tr style='background: #f0f0f0;'><th style='border: 1px solid #ddd; padding: 8px;'>ID</th><th style='border: 1px solid #ddd; padding: 8px;'>Name</th><th style='border: 1px solid #ddd; padding: 8px;'>Email</th><th style='border: 1px solid #ddd; padding: 8px;'>Role</th><th style='border: 1px solid #ddd; padding: 8px;'>Photo</th><th style='border: 1px solid #ddd; padding: 8px;'>Created</th></tr>";
    
    foreach ($users as $user) {
        $roleColor = '';
        if ($user['role'] === 'Admin') {
            $roleColor = 'color: red; font-weight: bold;';
        } elseif ($user['role'] === 'Warga') {
            $roleColor = 'color: blue;';
        } elseif ($user['role'] === 'Mitra') {
            $roleColor = 'color: green;';
        } else {
            $roleColor = 'color: orange; font-weight: bold;';
        }
        
        echo "<tr>";
        echo "<td style='border: 1px solid #ddd; padding: 8px;'>{$user['id']}</td>";
        echo "<td style='border: 1px solid #ddd; padding: 8px;'>{$user['name']}</td>";
        echo "<td style='border: 1px solid #ddd; padding: 8px;'>{$user['email']}</td>";
        echo "<td style='border: 1px solid #ddd; padding: 8px; $roleColor'>" . ($user['role'] ?: 'NULL') . "</td>";
        echo "<td style='border: 1px solid #ddd; padding: 8px;'>" . ($user['foto_profil'] ?: 'NULL') . "</td>";
        echo "<td style='border: 1px solid #ddd; padding: 8px;'>{$user['created_at']}</td>";
        echo "</tr>";
    }
    echo "</table>";
    
    // 3. Check specific user
    echo "<h2>3. Check Specific User (nick@gmail.com)</h2>";
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute(['nick@gmail.com']);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($user) {
        echo "<div style='background: rgba(255,255,255,0.95); padding: 15px; border-radius: 5px; margin: 10px 0;'>";
        echo "<h4>User Details:</h4>";
        echo "<p><strong>ID:</strong> {$user['id']}</p>";
        echo "<p><strong>Name:</strong> {$user['name']}</p>";
        echo "<p><strong>Email:</strong> {$user['email']}</p>";
        echo "<p><strong>Role:</strong> <span style='color: red; font-weight: bold;'>" . ($user['role'] ?: 'NULL') . "</span></p>";
        echo "<p><strong>Photo:</strong> " . ($user['foto_profil'] ?: 'NULL') . "</p>";
        echo "<p><strong>Created:</strong> {$user['created_at']}</p>";
        echo "</div>";
        
        // Try to update this user to Admin
        echo "<h3>Updating nick@gmail.com to Admin...</h3>";
        $stmt = $pdo->prepare("UPDATE users SET role = 'Admin' WHERE email = ?");
        $result = $stmt->execute(['nick@gmail.com']);
        
        if ($result) {
            echo "<p style='color: green;'>✅ Successfully updated nick@gmail.com to Admin role</p>";
            
            // Verify the update
            $stmt = $pdo->prepare("SELECT role FROM users WHERE email = ?");
            $stmt->execute(['nick@gmail.com']);
            $newRole = $stmt->fetchColumn();
            echo "<p style='color: blue;'>✅ Verified: Role is now '$newRole'</p>";
        } else {
            echo "<p style='color: red;'>❌ Failed to update role</p>";
        }
    } else {
        echo "<p style='color: orange;'>⚠️ User nick@gmail.com not found</p>";
    }
    
    echo "<h2>🎉 Debug Complete!</h2>";
    echo "<p><strong>Next steps:</strong></p>";
    echo "<ul style='background: rgba(255,255,255,0.9); padding: 15px; border-radius: 5px;'>";
    echo "<li>✅ Check if role column exists and has correct values</li>";
    echo "<li>✅ Verify user roles in database</li>";
    echo "<li>🔄 Try logging out and logging back in</li>";
    echo "<li>🗑️ Delete this file after use for security</li>";
    echo "</ul>";
    
} catch (PDOException $e) {
    echo "<h2 style='color: red;'>❌ Database Connection Error</h2>";
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

h1, h2, h3 {
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

ul {
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