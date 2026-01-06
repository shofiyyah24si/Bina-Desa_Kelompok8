<?php

/**
 * Quick fix script untuk update role dan foto user
 * Upload file ini ke hosting dan jalankan via browser
 */

// Konfigurasi database hosting (SESUAIKAN DENGAN HOSTING KAMU)
$host = 'mysql-shopi-sie.alwaysdata.net'; // sesuaikan dengan hosting
$dbname = 'shopi-sie_db'; // nama database hosting
$username = 'shopi-sie'; // username database hosting  
$password = 'Sh0opiie694'; // password database hosting (sesuaikan)

echo "<h1>🔧 Fix User Role & Photo</h1>";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "<p style='color: green;'>✅ Database connection successful!</p>";
    
    // 1. Show current users
    echo "<h2>1. Current Users</h2>";
    $stmt = $pdo->query("SELECT id, name, email, role, foto_profil FROM users ORDER BY id DESC");
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo "<table style='width: 100%; border-collapse: collapse; margin: 10px 0;'>";
    echo "<tr style='background: #f0f0f0;'><th style='border: 1px solid #ddd; padding: 8px;'>ID</th><th style='border: 1px solid #ddd; padding: 8px;'>Name</th><th style='border: 1px solid #ddd; padding: 8px;'>Email</th><th style='border: 1px solid #ddd; padding: 8px;'>Role</th><th style='border: 1px solid #ddd; padding: 8px;'>Photo</th></tr>";
    
    foreach ($users as $user) {
        $roleColor = $user['role'] === 'Admin' ? 'color: red; font-weight: bold;' : 'color: blue;';
        echo "<tr>";
        echo "<td style='border: 1px solid #ddd; padding: 8px;'>{$user['id']}</td>";
        echo "<td style='border: 1px solid #ddd; padding: 8px;'>{$user['name']}</td>";
        echo "<td style='border: 1px solid #ddd; padding: 8px;'>{$user['email']}</td>";
        echo "<td style='border: 1px solid #ddd; padding: 8px; $roleColor'>" . ($user['role'] ?: 'NULL') . "</td>";
        echo "<td style='border: 1px solid #ddd; padding: 8px;'>" . ($user['foto_profil'] ?: 'NULL') . "</td>";
        echo "</tr>";
    }
    echo "</table>";
    
    // 2. Fix roles for users without proper roles
    echo "<h2>2. Fixing User Roles</h2>";
    
    // Update users with specific emails to Admin
    $adminEmails = ['shopie@gmail.com', 'admin@admin.com']; // Add your email here
    
    foreach ($adminEmails as $email) {
        $stmt = $pdo->prepare("UPDATE users SET role = 'Admin' WHERE email = ?");
        $result = $stmt->execute([$email]);
        $affected = $stmt->rowCount();
        
        if ($affected > 0) {
            echo "<p style='color: green;'>✅ Updated user with email '$email' to Admin role</p>";
        } else {
            echo "<p style='color: blue;'>ℹ️ No user found with email '$email' or already has correct role</p>";
        }
    }
    
    // Update any users with NULL or empty roles to Warga
    $stmt = $pdo->prepare("UPDATE users SET role = 'Warga' WHERE role IS NULL OR role = '' OR role = 'User'");
    $result = $stmt->execute();
    $affected = $stmt->rowCount();
    
    if ($affected > 0) {
        echo "<p style='color: green;'>✅ Updated $affected users with missing/invalid roles to Warga</p>";
    } else {
        echo "<p style='color: blue;'>ℹ️ All users already have valid roles</p>";
    }
    
    // 3. Fix photo paths
    echo "<h2>3. Checking Photo Paths</h2>";
    $stmt = $pdo->query("SELECT id, name, foto_profil FROM users WHERE foto_profil IS NOT NULL AND foto_profil != ''");
    $usersWithPhotos = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    foreach ($usersWithPhotos as $user) {
        $photoPath = $user['foto_profil'];
        $fullPhotoPath = $_SERVER['DOCUMENT_ROOT'] . '/uploads/' . $photoPath;
        
        if (file_exists($fullPhotoPath)) {
            echo "<p style='color: green;'>✅ Photo exists for {$user['name']}: {$photoPath}</p>";
        } else {
            echo "<p style='color: orange;'>⚠️ Photo missing for {$user['name']}: {$photoPath}</p>";
            echo "<p style='color: gray;'>   Expected at: {$fullPhotoPath}</p>";
        }
    }
    
    // 4. Show updated users
    echo "<h2>4. Updated Users</h2>";
    $stmt = $pdo->query("SELECT id, name, email, role, foto_profil FROM users ORDER BY id DESC");
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo "<table style='width: 100%; border-collapse: collapse; margin: 10px 0;'>";
    echo "<tr style='background: #f0f0f0;'><th style='border: 1px solid #ddd; padding: 8px;'>ID</th><th style='border: 1px solid #ddd; padding: 8px;'>Name</th><th style='border: 1px solid #ddd; padding: 8px;'>Email</th><th style='border: 1px solid #ddd; padding: 8px;'>Role</th><th style='border: 1px solid #ddd; padding: 8px;'>Photo</th></tr>";
    
    foreach ($users as $user) {
        $roleColor = $user['role'] === 'Admin' ? 'color: red; font-weight: bold;' : 'color: blue;';
        echo "<tr>";
        echo "<td style='border: 1px solid #ddd; padding: 8px;'>{$user['id']}</td>";
        echo "<td style='border: 1px solid #ddd; padding: 8px;'>{$user['name']}</td>";
        echo "<td style='border: 1px solid #ddd; padding: 8px;'>{$user['email']}</td>";
        echo "<td style='border: 1px solid #ddd; padding: 8px; $roleColor'>" . ($user['role'] ?: 'NULL') . "</td>";
        echo "<td style='border: 1px solid #ddd; padding: 8px;'>" . ($user['foto_profil'] ?: 'NULL') . "</td>";
        echo "</tr>";
    }
    echo "</table>";
    
    echo "<h2>🎉 User Fix Complete!</h2>";
    echo "<p><strong>Next steps:</strong></p>";
    echo "<ul>";
    echo "<li>✅ User roles updated</li>";
    echo "<li>✅ Photo paths checked</li>";
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