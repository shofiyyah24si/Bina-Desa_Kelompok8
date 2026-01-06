<?php
/**
 * Script untuk menambah kolom foto_profil ke tabel posko_bencana
 * Jalankan dengan: php add_posko_foto_column.php
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

    // Check if foto_profil column exists in posko_bencana
    $columns = $pdo->query("SHOW COLUMNS FROM posko_bencana");
    $existingColumns = [];
    while ($column = $columns->fetch(PDO::FETCH_ASSOC)) {
        $existingColumns[] = $column['Field'];
    }

    if (in_array('foto_profil', $existingColumns)) {
        echo "ℹ️  Kolom 'foto_profil' sudah ada di tabel posko_bencana.\n";
    } else {
        echo "🔧 Menambahkan kolom 'foto_profil' ke tabel posko_bencana...\n";
        
        $addColumn = "
            ALTER TABLE `posko_bencana` 
            ADD COLUMN `foto_profil` VARCHAR(500) NULL 
            COMMENT 'Path foto posko relatif dari public/uploads/' 
            AFTER `penanggung_jawab`
        ";
        
        $pdo->exec($addColumn);
        echo "✅ Kolom 'foto_profil' berhasil ditambahkan!\n";
    }

    // Show final table structure
    echo "\n📋 Struktur tabel posko_bencana sekarang:\n";
    $columns = $pdo->query("SHOW COLUMNS FROM posko_bencana");
    while ($column = $columns->fetch(PDO::FETCH_ASSOC)) {
        echo "   - {$column['Field']} ({$column['Type']})\n";
    }

    echo "\n🎉 Setup kolom foto_profil untuk posko selesai!\n";
    echo "📝 Posko akan menggunakan single photo dengan kolom foto_profil\n";
    echo "📝 Kejadian akan menggunakan multiple photos dengan tabel media\n";

} catch (PDOException $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    exit(1);
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    exit(1);
}