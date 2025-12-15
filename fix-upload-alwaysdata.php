<?php

echo "========================================\n";
echo "PERBAIKAN UPLOAD UNTUK ALWAYSDATA\n";
echo "========================================\n\n";

// 1. Create necessary directories
echo "1. CREATING DIRECTORIES...\n";
$directories = [
    'public/uploads',
    'public/uploads/users',
    'public/uploads/warga',
    'public/uploads/kejadian_bencana', 
    'public/uploads/posko_bencana',
    'public/uploads/donasi_bencana',
    'storage/app/public'
];

foreach ($directories as $dir) {
    if (!file_exists($dir)) {
        if (mkdir($dir, 0755, true)) {
            echo "   ✓ Created: $dir\n";
        } else {
            echo "   ✗ Failed to create: $dir\n";
        }
    } else {
        echo "   ✓ Exists: $dir\n";
    }
    
    // Set permissions
    chmod($dir, 0755);
}

echo "\n";

// 2. Create .htaccess for uploads
echo "2. CREATING .HTACCESS FILES...\n";

$uploadsHtaccess = 'public/uploads/.htaccess';
$htaccessContent = '# Allow image files
<FilesMatch "\.(jpg|jpeg|png|gif|webp|svg)$">
    Order Allow,Deny
    Allow from all
</FilesMatch>

# Deny access to PHP files
<FilesMatch "\.php$">
    Order Deny,Allow
    Deny from all
</FilesMatch>

# Set proper MIME types
<IfModule mod_mime.c>
    AddType image/jpeg .jpg .jpeg
    AddType image/png .png
    AddType image/gif .gif
    AddType image/webp .webp
    AddType image/svg+xml .svg
</IfModule>

# Enable compression for images
<IfModule mod_deflate.c>
    <FilesMatch "\.(jpg|jpeg|png|gif|webp)$">
        SetOutputFilter DEFLATE
    </FilesMatch>
</IfModule>

# Set cache headers for images
<IfModule mod_expires.c>
    ExpiresActive On
    ExpiresByType image/jpeg "access plus 1 month"
    ExpiresByType image/png "access plus 1 month"
    ExpiresByType image/gif "access plus 1 month"
    ExpiresByType image/webp "access plus 1 month"
</IfModule>';

if (file_put_contents($uploadsHtaccess, $htaccessContent)) {
    echo "   ✓ Created: $uploadsHtaccess\n";
} else {
    echo "   ✗ Failed to create: $uploadsHtaccess\n";
}

echo "\n";

// 3. Create test images
echo "3. CREATING TEST IMAGES...\n";

// Create a simple test image
$testDirs = ['public/uploads/users', 'public/uploads/warga'];

foreach ($testDirs as $testDir) {
    $testImage = $testDir . '/test.jpg';
    
    // Create a simple 100x100 red image
    $image = imagecreate(100, 100);
    $red = imagecolorallocate($image, 255, 0, 0);
    imagefill($image, 0, 0, $red);
    
    if (imagejpeg($image, $testImage)) {
        echo "   ✓ Created test image: $testImage\n";
    } else {
        echo "   ✗ Failed to create test image: $testImage\n";
    }
    
    imagedestroy($image);
}

echo "\n";

// 4. Test URL access
echo "4. TESTING URL ACCESS...\n";

$baseUrl = 'http://localhost:8000'; // Change this for production
$testUrls = [
    '/uploads/users/test.jpg',
    '/storage' // Test storage link
];

foreach ($testUrls as $url) {
    $fullUrl = $baseUrl . $url;
    echo "   Testing: $fullUrl\n";
    
    // You can uncomment this for actual URL testing
    /*
    $headers = @get_headers($fullUrl);
    if ($headers && strpos($headers[0], '200') !== false) {
        echo "   ✓ Accessible\n";
    } else {
        echo "   ✗ Not accessible\n";
    }
    */
}

echo "\n";

// 5. Create sample database records
echo "5. SAMPLE DATABASE RECORDS...\n";

try {
    $pdo = new PDO('mysql:host=127.0.0.1;port=3309;dbname=laravel', 'root', '');
    
    // Check if media table exists
    $stmt = $pdo->query("SHOW TABLES LIKE 'media'");
    if ($stmt->rowCount() > 0) {
        echo "   ✓ Media table exists\n";
        
        // Show current records
        $stmt = $pdo->query("SELECT COUNT(*) FROM media");
        $count = $stmt->fetchColumn();
        echo "   Current media records: $count\n";
        
    } else {
        echo "   ✗ Media table does not exist\n";
        echo "   Run: php artisan migrate\n";
    }
    
} catch (Exception $e) {
    echo "   ✗ Database error: " . $e->getMessage() . "\n";
}

echo "\n========================================\n";
echo "PERBAIKAN SELESAI!\n";
echo "========================================\n\n";

echo "LANGKAH SELANJUTNYA UNTUK ALWAYSDATA:\n";
echo "1. Upload semua file ke server\n";
echo "2. Jalankan: php artisan storage:link\n";
echo "3. Set permissions: chmod -R 755 public/uploads\n";
echo "4. Set permissions: chmod -R 755 storage/app/public\n";
echo "5. Test upload foto melalui aplikasi\n";
echo "6. Cek apakah foto muncul di browser\n\n";

?>