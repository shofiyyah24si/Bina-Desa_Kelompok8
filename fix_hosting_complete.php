<?php

/**
 * Script lengkap untuk fix hosting setelah migrate:fresh
 * Upload file ini ke hosting dan jalankan via browser
 */

// Konfigurasi database hosting (SESUAIKAN DENGAN HOSTING KAMU)
$host = 'mysql-shopi-sie.alwaysdata.net'; // sesuaikan dengan hosting
$dbname = 'shopi-sie_db'; // nama database hosting
$username = 'shopi-sie'; // username database hosting  
$password = 'Sh0opiie694'; // password database hosting (sesuaikan)

echo "<h1>🔧 Fix Hosting Database</h1>";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "<p style='color: green;'>✅ Database connection successful!</p>";
    
    // 1. Create sessions table
    echo "<h2>1. Creating Sessions Table</h2>";
    try {
        $sql = "
        CREATE TABLE IF NOT EXISTS `sessions` (
          `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
          `user_id` bigint unsigned DEFAULT NULL,
          `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
          `user_agent` text COLLATE utf8mb4_unicode_ci,
          `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
          `last_activity` int NOT NULL,
          PRIMARY KEY (`id`),
          KEY `sessions_user_id_index` (`user_id`),
          KEY `sessions_last_activity_index` (`last_activity`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
        ";
        
        $pdo->exec($sql);
        echo "<p style='color: green;'>✅ Sessions table created/verified!</p>";
    } catch (Exception $e) {
        echo "<p style='color: orange;'>⚠️ Sessions table: " . $e->getMessage() . "</p>";
    }
    
    // 2. Check all required tables and create missing ones
    echo "<h2>2. Creating Missing Tables</h2>";
    
    // Create media table if it doesn't exist
    try {
        $sql = "
        CREATE TABLE IF NOT EXISTS `media` (
          `media_id` bigint unsigned NOT NULL AUTO_INCREMENT,
          `ref_table` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
          `ref_id` bigint unsigned NOT NULL,
          `file_url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
          `caption` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
          `mime_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
          `sort_order` int NOT NULL DEFAULT '0',
          `created_at` timestamp NULL DEFAULT NULL,
          `updated_at` timestamp NULL DEFAULT NULL,
          PRIMARY KEY (`media_id`),
          KEY `media_ref_table_ref_id_index` (`ref_table`,`ref_id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
        ";
        
        $pdo->exec($sql);
        echo "<p style='color: green;'>✅ Media table created/verified!</p>";
    } catch (Exception $e) {
        echo "<p style='color: orange;'>⚠️ Media table: " . $e->getMessage() . "</p>";
    }
    
    // Check all required tables
    echo "<h3>Checking Required Tables</h3>";
    $requiredTables = [
        'users', 'warga', 'kejadian_bencana', 'posko_bencana', 
        'donasi_bencana', 'logistik_bencana', 'distribusi_logistik', 
        'media', 'sessions', 'migrations'
    ];
    
    foreach ($requiredTables as $table) {
        $stmt = $pdo->query("SHOW TABLES LIKE '$table'");
        if ($stmt->rowCount() > 0) {
            echo "<p style='color: green;'>✅ Table '$table' exists</p>";
        } else {
            echo "<p style='color: red;'>❌ Table '$table' missing!</p>";
        }
    }
    
    // 3. Create admin user if not exists
    echo "<h2>3. Adding Missing Columns to Users Table</h2>";
    try {
        // Get current columns
        $stmt = $pdo->query("DESCRIBE users");
        $existingColumns = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $existingColumns[] = $row['Field'];
        }
        
        // Required columns for users table
        $requiredColumns = [
            'role' => "VARCHAR(50) DEFAULT 'Warga'",
            'foto_profil' => "VARCHAR(255) NULL",
            'avatar' => "VARCHAR(255) NULL",
            'last_login' => "TIMESTAMP NULL",
            'last_login_at' => "TIMESTAMP NULL"
        ];
        
        foreach ($requiredColumns as $column => $definition) {
            if (!in_array($column, $existingColumns)) {
                $sql = "ALTER TABLE users ADD COLUMN `$column` $definition";
                $pdo->exec($sql);
                echo "<p style='color: green;'>✅ Added column '$column' to users table</p>";
            } else {
                echo "<p style='color: blue;'>ℹ️ Column '$column' already exists</p>";
            }
        }
        
    } catch (Exception $e) {
        echo "<p style='color: orange;'>⚠️ Adding columns: " . $e->getMessage() . "</p>";
    }
    
    // 4. Create admin user if not exists and update existing users
    echo "<h2>4. Managing Admin Users</h2>";
    try {
        // First, check if there are any users without roles and update them
        $stmt = $pdo->query("SELECT id, name, email FROM users WHERE role IS NULL OR role = ''");
        $usersWithoutRole = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        if (!empty($usersWithoutRole)) {
            echo "<h3>Updating Users Without Roles</h3>";
            foreach ($usersWithoutRole as $user) {
                // Set first user as Admin, others as Warga
                $role = ($user['id'] == 1 || strpos(strtolower($user['email']), 'admin') !== false) ? 'Admin' : 'Warga';
                $pdo->exec("UPDATE users SET role = '$role' WHERE id = " . $user['id']);
                echo "<p style='color: green;'>✅ Updated user '{$user['name']}' ({$user['email']}) to role: $role</p>";
            }
        }
        
        // Check if admin user exists
        $stmt = $pdo->query("SELECT COUNT(*) FROM users WHERE email = 'admin@admin.com'");
        $adminExists = $stmt->fetchColumn();
        
        if ($adminExists == 0) {
            // Check which columns exist before inserting
            $stmt = $pdo->query("DESCRIBE users");
            $columns = [];
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $columns[] = $row['Field'];
            }
            
            $insertColumns = ['name', 'email', 'password', 'created_at', 'updated_at'];
            $insertValues = [
                "'Admin'", 
                "'admin@admin.com'", 
                "'$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'", 
                'NOW()', 
                'NOW()'
            ];
            
            if (in_array('role', $columns)) {
                $insertColumns[] = 'role';
                $insertValues[] = "'Admin'";
            }
            
            $sql = "INSERT INTO users (" . implode(', ', $insertColumns) . ") VALUES (" . implode(', ', $insertValues) . ")";
            $pdo->exec($sql);
            echo "<p style='color: green;'>✅ Admin user created! Email: admin@admin.com, Password: password</p>";
        } else {
            echo "<p style='color: blue;'>ℹ️ Admin user already exists</p>";
        }
        
        // Show current users and their roles
        echo "<h3>Current Users and Roles</h3>";
        $stmt = $pdo->query("SELECT id, name, email, role FROM users ORDER BY id");
        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        echo "<table style='width: 100%; border-collapse: collapse; margin: 10px 0;'>";
        echo "<tr style='background: #f0f0f0;'><th style='border: 1px solid #ddd; padding: 8px;'>ID</th><th style='border: 1px solid #ddd; padding: 8px;'>Name</th><th style='border: 1px solid #ddd; padding: 8px;'>Email</th><th style='border: 1px solid #ddd; padding: 8px;'>Role</th></tr>";
        
        foreach ($users as $user) {
            $roleColor = $user['role'] === 'Admin' ? 'color: red; font-weight: bold;' : 'color: blue;';
            echo "<tr>";
            echo "<td style='border: 1px solid #ddd; padding: 8px;'>{$user['id']}</td>";
            echo "<td style='border: 1px solid #ddd; padding: 8px;'>{$user['name']}</td>";
            echo "<td style='border: 1px solid #ddd; padding: 8px;'>{$user['email']}</td>";
            echo "<td style='border: 1px solid #ddd; padding: 8px; $roleColor'>{$user['role']}</td>";
            echo "</tr>";
        }
        echo "</table>";
        
    } catch (Exception $e) {
        echo "<p style='color: orange;'>⚠️ Admin user management: " . $e->getMessage() . "</p>";
    }
    
    // 5. Clear cache and sessions
    echo "<h2>5. Clearing Cache</h2>";
    try {
        $pdo->exec("DELETE FROM sessions WHERE last_activity < " . (time() - 3600));
        echo "<p style='color: green;'>✅ Old sessions cleared</p>";
    } catch (Exception $e) {
        echo "<p style='color: orange;'>⚠️ Session cleanup: " . $e->getMessage() . "</p>";
    }
    
    echo "<h2>🎉 Hosting Fix Complete!</h2>";
    echo "<p><strong>Next steps:</strong></p>";
    echo "<ul>";
    echo "<li>✅ Database tables are ready</li>";
    echo "<li>✅ Sessions table created</li>";
    echo "<li>✅ Admin user available (if created)</li>";
    echo "<li>🔗 Try accessing your website now</li>";
    echo "<li>🗑️ Delete this file after use for security</li>";
    echo "</ul>";
    
} catch (PDOException $e) {
    echo "<h2 style='color: red;'>❌ Database Connection Error</h2>";
    echo "<p>Error: " . $e->getMessage() . "</p>";
    echo "<p><strong>Please check:</strong></p>";
    echo "<ul>";
    echo "<li>Database host: $host</li>";
    echo "<li>Database name: $dbname</li>";
    echo "<li>Username: $username</li>";
    echo "<li>Password: [hidden]</li>";
    echo "</ul>";
    echo "<p>Update the credentials at the top of this file.</p>";
}

?>

<style>
body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    max-width: 900px;
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

.success { border-left-color: #28a745; }
.warning { border-left-color: #ffc107; }
.error { border-left-color: #dc3545; }
.info { border-left-color: #17a2b8; }
</style>