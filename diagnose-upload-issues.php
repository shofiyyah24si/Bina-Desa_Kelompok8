<?php

echo "========================================\n";
echo "DIAGNOSIS MASALAH UPLOAD FOTO\n";
echo "========================================\n\n";

// 1. Check PHP upload settings
echo "1. PHP UPLOAD SETTINGS:\n";
echo "   file_uploads: " . (ini_get('file_uploads') ? 'ON' : 'OFF') . "\n";
echo "   upload_max_filesize: " . ini_get('upload_max_filesize') . "\n";
echo "   post_max_size: " . ini_get('post_max_size') . "\n";
echo "   max_file_uploads: " . ini_get('max_file_uploads') . "\n";
echo "   memory_limit: " . ini_get('memory_limit') . "\n";
echo "   max_execution_time: " . ini_get('max_execution_time') . "s\n\n";

// 2. Check directories
echo "2. DIRECTORY PERMISSIONS:\n";
$directories = [
    'public/uploads',
    'public/uploads/users',
    'public/uploads/warga', 
    'public/uploads/kejadian_bencana',
    'public/uploads/posko_bencana',
    'public/uploads/donasi_bencana',
    'storage/app/public',
    'storage/logs'
];

foreach ($directories as $dir) {
    if (file_exists($dir)) {
        $perms = substr(sprintf('%o', fileperms($dir)), -4);
        $writable = is_writable($dir) ? 'WRITABLE' : 'NOT WRITABLE';
        echo "   ✓ $dir: $perms ($writable)\n";
        
        // Count files in directory
        $files = glob($dir . '/*');
        echo "     Files: " . count($files) . "\n";
    } else {
        echo "   ✗ $dir: DOES NOT EXIST\n";
    }
}

echo "\n";

// 3. Check storage link
echo "3. STORAGE LINK:\n";
$storageLink = public_path('storage');
if (is_link($storageLink)) {
    $target = readlink($storageLink);
    echo "   ✓ Storage link exists: $storageLink -> $target\n";
} else {
    echo "   ✗ Storage link missing: $storageLink\n";
    echo "   Run: php artisan storage:link\n";
}

echo "\n";

// 4. Test file creation
echo "4. FILE CREATION TEST:\n";
$testDirs = ['public/uploads', 'storage/app/public'];

foreach ($testDirs as $testDir) {
    if (file_exists($testDir)) {
        $testFile = $testDir . '/test_' . time() . '.txt';
        if (file_put_contents($testFile, 'test')) {
            echo "   ✓ Can create files in $testDir\n";
            unlink($testFile);
        } else {
            echo "   ✗ Cannot create files in $testDir\n";
        }
    }
}

echo "\n";

// 5. Check .htaccess
echo "5. HTACCESS FILES:\n";
$htaccessFiles = [
    'public/.htaccess',
    'public/uploads/.htaccess'
];

foreach ($htaccessFiles as $htaccess) {
    if (file_exists($htaccess)) {
        echo "   ✓ $htaccess exists\n";
    } else {
        echo "   ✗ $htaccess missing\n";
    }
}

echo "\n";

// 6. Check database for media records
echo "6. DATABASE MEDIA RECORDS:\n";
try {
    $pdo = new PDO('mysql:host=127.0.0.1;port=3309;dbname=laravel', 'root', '');
    
    $stmt = $pdo->query("SELECT COUNT(*) as total FROM media");
    $total = $stmt->fetchColumn();
    echo "   Total media records: $total\n";
    
    if ($total > 0) {
        $stmt = $pdo->query("SELECT ref_table, COUNT(*) as count FROM media GROUP BY ref_table");
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "   - {$row['ref_table']}: {$row['count']} files\n";
        }
        
        // Show some sample file paths
        echo "\n   Sample file paths:\n";
        $stmt = $pdo->query("SELECT file_url FROM media LIMIT 5");
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $fullPath = public_path('uploads/' . $row['file_url']);
            $exists = file_exists($fullPath) ? '✓' : '✗';
            echo "   $exists uploads/{$row['file_url']}\n";
        }
    }
    
} catch (Exception $e) {
    echo "   ✗ Database connection failed: " . $e->getMessage() . "\n";
}

echo "\n";

// 7. Check web server configuration
echo "7. WEB SERVER INFO:\n";
echo "   Server Software: " . ($_SERVER['SERVER_SOFTWARE'] ?? 'Unknown') . "\n";
echo "   Document Root: " . ($_SERVER['DOCUMENT_ROOT'] ?? 'Unknown') . "\n";
echo "   Script Name: " . ($_SERVER['SCRIPT_NAME'] ?? 'Unknown') . "\n";

echo "\n========================================\n";
echo "DIAGNOSIS COMPLETED!\n";
echo "========================================\n";

?>