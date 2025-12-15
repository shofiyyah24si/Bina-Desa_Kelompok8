<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class TestUpload extends Command
{
    protected $signature = 'test:upload';
    protected $description = 'Test upload functionality and permissions';

    public function handle()
    {
        $this->info('Testing upload functionality...');
        
        // Test directory permissions
        $uploadPath = public_path('uploads');
        $this->info("Upload path: $uploadPath");
        
        if (!file_exists($uploadPath)) {
            $this->error("Upload directory does not exist!");
            return 1;
        }
        
        if (!is_writable($uploadPath)) {
            $this->error("Upload directory is not writable!");
            $this->info("Try running: chmod 755 $uploadPath");
            return 1;
        }
        
        $this->info("✓ Upload directory exists and is writable");
        
        // Test subdirectories
        $subdirs = ['kejadian_bencana', 'posko_bencana', 'donasi_bencana'];
        
        foreach ($subdirs as $subdir) {
            $path = $uploadPath . '/' . $subdir;
            if (!file_exists($path)) {
                mkdir($path, 0755, true);
                $this->info("✓ Created directory: $subdir");
            } else {
                $this->info("✓ Directory exists: $subdir");
            }
            
            if (!is_writable($path)) {
                $this->error("Directory not writable: $subdir");
            }
        }
        
        // Test file creation
        $testFile = $uploadPath . '/test.txt';
        if (file_put_contents($testFile, 'test')) {
            unlink($testFile);
            $this->info("✓ File creation test passed");
        } else {
            $this->error("✗ File creation test failed");
        }
        
        // Check PHP upload settings
        $this->info("\nPHP Upload Settings:");
        $this->info("file_uploads: " . (ini_get('file_uploads') ? 'On' : 'Off'));
        $this->info("upload_max_filesize: " . ini_get('upload_max_filesize'));
        $this->info("post_max_size: " . ini_get('post_max_size'));
        $this->info("max_file_uploads: " . ini_get('max_file_uploads'));
        $this->info("memory_limit: " . ini_get('memory_limit'));
        
        $this->info("\n✓ Upload test completed!");
        return 0;
    }
}