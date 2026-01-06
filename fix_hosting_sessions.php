<?php

/**
 * Script untuk fix session table di hosting
 * Upload file ini ke hosting dan jalankan via browser
 */

// Konfigurasi database hosting (sesuaikan dengan hosting kamu)
$host = 'localhost'; // atau IP hosting
$dbname = 'shopi-sie_db'; // nama database hosting
$username = 'username_hosting'; // username database hosting
$password = 'password_hosting'; // password database hosting

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "<h2>Fixing Sessions Table for Hosting</h2>";
    
    // Check if sessions table exists
    $stmt = $pdo->query("SHOW TABLES LIKE 'sessions'");
    if ($stmt->rowCount() > 0) {
        echo "<p style='color: green;'>✅ Sessions table already exists!</p>";
    } else {
        echo "<p style='color: orange;'>⚠️ Sessions table not found. Creating...</p>";
        
        // Create sessions table
        $sql = "
        CREATE TABLE `sessions` (
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
        echo "<p style='color: green;'>✅ Sessions table created successfully!</p>";
    }
    
    // Check table structure
    $stmt = $pdo->query("DESCRIBE sessions");
    echo "<h3>Sessions Table Structure:</h3>";
    echo "<table border='1' style='border-collapse: collapse;'>";
    echo "<tr><th>Field</th><th>Type</th><th>Null</th><th>Key</th></tr>";
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "<tr>";
        echo "<td>{$row['Field']}</td>";
        echo "<td>{$row['Type']}</td>";
        echo "<td>{$row['Null']}</td>";
        echo "<td>{$row['Key']}</td>";
        echo "</tr>";
    }
    echo "</table>";
    
    echo "<h3>✅ Sessions table is ready!</h3>";
    echo "<p>Your Laravel application should now work properly on hosting.</p>";
    
} catch (PDOException $e) {
    echo "<h2 style='color: red;'>❌ Database Connection Error</h2>";
    echo "<p>Error: " . $e->getMessage() . "</p>";
    echo "<p>Please check your database credentials in this script.</p>";
}

?>

<style>
body {
    font-family: Arial, sans-serif;
    max-width: 800px;
    margin: 50px auto;
    padding: 20px;
    background: #f5f5f5;
}

table {
    width: 100%;
    margin: 20px 0;
}

th, td {
    padding: 10px;
    text-align: left;
}

th {
    background: #333;
    color: white;
}

tr:nth-child(even) {
    background: #f9f9f9;
}
</style>