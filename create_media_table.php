<?php
/**
 * Script untuk membuat tabel media jika belum ada
 * Jalankan dengan: php create_media_table.php
 */

require_once 'vendor/autoload.php';

// Load environment variables
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

try {
    // Database connection
    $host = $_ENV['DB_HOST'] ?? 'localhost';
    $port = $_ENV['DB_PORT'] ?? '3306';
    $dbname = $_ENV['DB_DATABASE'] ?? 'laravel';
    $username = $_ENV['DB_USERNAME'] ?? 'root';
    $password = $_ENV['DB_PASSWORD'] ?? '';

    $pdo = new PDO("mysql:host=$host;port=$port;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    echo "✅ Koneksi database berhasil!\n";

    // Check if media table exists
    $checkTable = $pdo->query("SHOW TABLES LIKE 'media'");
    if ($checkTable->rowCount() > 0) {
        echo "ℹ️  Tabel 'media' sudah ada.\n";
        
        // Check columns
        $columns = $pdo->query("SHOW COLUMNS FROM media");
        $existingColumns = [];
        while ($column = $columns->fetch(PDO::FETCH_ASSOC)) {
            $existingColumns[] = $column['Field'];
        }
        
        echo "📋 Kolom yang ada: " . implode(', ', $existingColumns) . "\n";
        
    } else {
        echo "🔧 Membuat tabel 'media'...\n";
        
        $createTable = "
            CREATE TABLE `media` (
                `media_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
                `ref_table` varchar(100) NOT NULL COMMENT 'Nama tabel referensi (kejadian_bencana, posko_bencana, dll)',
                `ref_id` bigint(20) unsigned NOT NULL COMMENT 'ID dari tabel referensi',
                `file_url` varchar(500) NOT NULL COMMENT 'Path file relatif dari public/uploads/',
                `caption` text DEFAULT NULL COMMENT 'Keterangan foto',
                `mime_type` varchar(100) DEFAULT NULL COMMENT 'Tipe file (image/jpeg, dll)',
                `sort_order` int(11) DEFAULT 0 COMMENT 'Urutan foto',
                `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
                `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                PRIMARY KEY (`media_id`),
                KEY `idx_ref` (`ref_table`, `ref_id`),
                KEY `idx_sort` (`sort_order`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Tabel untuk menyimpan multiple foto/media'
        ";
        
        $pdo->exec($createTable);
        echo "✅ Tabel 'media' berhasil dibuat!\n";
    }

    // Test insert sample data (optional)
    echo "\n🧪 Testing tabel media...\n";
    
    // Check if we can insert and select
    $testInsert = $pdo->prepare("
        INSERT INTO media (ref_table, ref_id, file_url, caption, mime_type, sort_order) 
        VALUES ('test_table', 999, 'test/sample.jpg', 'Test photo', 'image/jpeg', 1)
    ");
    $testInsert->execute();
    
    $testId = $pdo->lastInsertId();
    echo "✅ Test insert berhasil dengan ID: $testId\n";
    
    // Clean up test data
    $cleanup = $pdo->prepare("DELETE FROM media WHERE media_id = ?");
    $cleanup->execute([$testId]);
    echo "🧹 Test data dibersihkan\n";

    echo "\n🎉 Setup tabel media selesai!\n";
    echo "📝 Struktur tabel:\n";
    echo "   - media_id: Primary key\n";
    echo "   - ref_table: Nama tabel (kejadian_bencana, posko_bencana)\n";
    echo "   - ref_id: ID dari tabel referensi\n";
    echo "   - file_url: Path file dari public/uploads/\n";
    echo "   - caption: Keterangan foto (opsional)\n";
    echo "   - mime_type: Tipe file\n";
    echo "   - sort_order: Urutan foto\n";
    echo "   - created_at, updated_at: Timestamp\n";

} catch (PDOException $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    exit(1);
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    exit(1);
}