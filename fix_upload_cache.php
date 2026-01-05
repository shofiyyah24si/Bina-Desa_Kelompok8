<?php

/**
 * Script untuk clear cache dan fix upload issues
 * Jalankan: php fix_upload_cache.php
 */

echo "=== FIXING UPLOAD ISSUES ===\n\n";

// Clear various caches
$commands = [
    'php artisan config:clear',
    'php artisan cache:clear', 
    'php artisan view:clear',
    'php artisan route:clear',
    'php artisan optimize:clear'
];

foreach ($commands as $cmd) {
    echo "Running: $cmd\n";
    $output = shell_exec($cmd . ' 2>&1');
    echo "Output: " . trim($output) . "\n\n";
}

// Check upload directories
echo "Checking upload directories:\n";
$dirs = [
    'public/uploads/kejadian_bencana',
    'public/uploads/posko_bencana',
    'public/uploads/donasi_bencana'
];

foreach ($dirs as $dir) {
    if (!is_dir($dir)) {
        mkdir($dir, 0755, true);
        echo "Created: $dir\n";
    } else {
        echo "Exists: $dir\n";
    }
    
    // Check permissions
    $perms = substr(sprintf('%o', fileperms($dir)), -4);
    echo "Permissions: $perms\n";
}

echo "\n=== CACHE CLEARED & DIRECTORIES CHECKED ===\n";
echo "Now test the upload functionality!\n";