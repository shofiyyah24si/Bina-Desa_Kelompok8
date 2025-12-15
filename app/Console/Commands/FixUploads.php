<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class FixUploads extends Command
{
    protected $signature = 'fix:uploads';
    protected $description = 'Fix upload directories and permissions for hosting';

    public function handle()
    {
        $this->info('🔧 Fixing upload configuration...');

        // 1. Create directories
        $this->createDirectories();

        // 2. Set permissions
        $this->setPermissions();

        // 3. Create storage link
        $this->createStorageLink();

        // 4. Create .htaccess
        $this->createHtaccess();

        // 5. Test directories
        $this->testDirectories();

        $this->info('✅ Upload fix completed!');
    }

    private function createDirectories()
    {
        $this->info('📁 Creating directories...');

        $directories = [
            'public/uploads',
            'public/uploads/users',
            'public/uploads/warga',
            'public/uploads/kejadian_bencana',
            'public/uploads/posko_bencana',
            'public/uploads/donasi_bencana',
            'storage/app/public',
        ];

        foreach ($directories as $dir) {
            if (!File::exists($dir)) {
                File::makeDirectory($dir, 0755, true);
                $this->line("   ✓ Created: $dir");
            } else {
                $this->line("   ✓ Exists: $dir");
            }
        }
    }

    private function setPermissions()
    {
        $this->info('🔐 Setting permissions...');

        $directories = [
            'public/uploads',
            'storage/app/public',
            'storage/logs',
            'bootstrap/cache',
        ];

        foreach ($directories as $dir) {
            if (File::exists($dir)) {
                chmod($dir, 0755);
                $this->line("   ✓ Set 755: $dir");
            }
        }
    }

    private function createStorageLink()
    {
        $this->info('🔗 Creating storage link...');

        $link = public_path('storage');
        $target = storage_path('app/public');

        if (!File::exists($link)) {
            if (symlink($target, $link)) {
                $this->line("   ✓ Created storage link");
            } else {
                $this->error("   ✗ Failed to create storage link");
            }
        } else {
            $this->line("   ✓ Storage link exists");
        }
    }

    private function createHtaccess()
    {
        $this->info('📄 Creating .htaccess...');

        $htaccessPath = public_path('uploads/.htaccess');
        $content = '# Allow image files
<FilesMatch "\.(jpg|jpeg|png|gif|webp|svg)$">
    Order Allow,Deny
    Allow from all
</FilesMatch>

# Deny access to PHP files
<FilesMatch "\.php$">
    Order Deny,Allow
    Deny from all
</FilesMatch>';

        if (File::put($htaccessPath, $content)) {
            $this->line("   ✓ Created .htaccess");
        } else {
            $this->error("   ✗ Failed to create .htaccess");
        }
    }

    private function testDirectories()
    {
        $this->info('🧪 Testing directories...');

        $testDirs = [
            'public/uploads',
            'storage/app/public',
        ];

        foreach ($testDirs as $dir) {
            $testFile = $dir . '/test_' . time() . '.txt';
            
            if (File::put($testFile, 'test')) {
                File::delete($testFile);
                $this->line("   ✓ Writable: $dir");
            } else {
                $this->error("   ✗ Not writable: $dir");
            }
        }
    }
}