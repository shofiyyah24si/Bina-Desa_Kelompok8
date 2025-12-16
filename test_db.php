<?php
// Simple test to check database connection
try {
    $pdo = new PDO('mysql:host=127.0.0.1;port=3309;dbname=laravel', 'root', '');
    echo "Database connection successful!\n";
    
    // Check if table exists
    $stmt = $pdo->query("SHOW TABLES LIKE 'donasi_bencana'");
    if ($stmt->rowCount() > 0) {
        echo "Table 'donasi_bencana' exists!\n";
        
        // Check columns
        $stmt = $pdo->query("DESCRIBE donasi_bencana");
        echo "Columns in donasi_bencana:\n";
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "- " . $row['Field'] . " (" . $row['Type'] . ")\n";
        }
    } else {
        echo "Table 'donasi_bencana' does not exist!\n";
    }
    
} catch (PDOException $e) {
    echo "Database connection failed: " . $e->getMessage() . "\n";
}
?>