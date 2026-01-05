<?php

/**
 * Script untuk testing shared storage
 * Jalankan: php test_shared_storage.php
 */

require_once 'vendor/autoload.php';

// Load environment
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

echo "=== TESTING SHARED STORAGE ===\n\n";

// Test 1: Cek konfigurasi
echo "1. Checking Configuration:\n";
echo "   SHARED_STORAGE_URL: " . ($_ENV['SHARED_STORAGE_URL'] ?? 'NOT SET') . "\n";
echo "   USE_CLOUD_STORAGE: " . ($_ENV['USE_CLOUD_STORAGE'] ?? 'false') . "\n\n";

// Test 2: Cek folder uploads
echo "2. Checking Upload Directories:\n";
$uploadDirs = [
    'public/uploads/kejadian_bencana',
    'public/uploads/posko_bencana', 
    'public/uploads/donasi_bencana',
    'public/uploads/users',
    'public/uploads/warga'
];

foreach ($uploadDirs as $dir) {
    $exists = is_dir($dir);
    $count = $exists ? count(glob($dir . '/*')) : 0;
    echo "   $dir: " . ($exists ? "✅ EXISTS ($count files)" : "❌ NOT FOUND") . "\n";
}

echo "\n";

// Test 3: Test ImageHelper
echo "3. Testing ImageHelper:\n";
if (class_exists('App\Helpers\ImageHelper')) {
    $testPaths = [
        'kejadian_bencana/test.jpg',
        'users/test.jpg',
        'nonexistent/file.jpg'
    ];
    
    foreach ($testPaths as $path) {
        try {
            $url = App\Helpers\ImageHelper::getImageUrl($path);
            echo "   $path → $url\n";
        } catch (Exception $e) {
            echo "   $path → ERROR: " . $e->getMessage() . "\n";
        }
    }
} else {
    echo "   ❌ ImageHelper class not found\n";
}

echo "\n";

// Test 4: Test URL accessibility
echo "4. Testing URL Accessibility:\n";
$sharedUrl = $_ENV['SHARED_STORAGE_URL'] ?? null;
if ($sharedUrl) {
    $testUrl = rtrim($sharedUrl, '/') . '/uploads/';
    echo "   Testing: $testUrl\n";
    
    $headers = @get_headers($testUrl);
    if ($headers && strpos($headers[0], '200') !== false) {
        echo "   ✅ URL accessible\n";
    } else {
        echo "   ❌ URL not accessible or returns error\n";
        echo "   Response: " . ($headers[0] ?? 'No response') . "\n";
    }
} else {
    echo "   ⚠️  SHARED_STORAGE_URL not configured\n";
}

echo "\n=== TEST COMPLETED ===\n";