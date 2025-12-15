<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Warga;
use App\Models\KejadianBencana;
use App\Models\PoskoBencana;
use App\Models\DonasiBencana;
use App\Models\LogistikBencana;
use App\Models\DistribusiLogistik;
use Illuminate\Support\Facades\Hash;

class ProductionSeeder extends Seeder
{
    /**
     * Run the database seeds for production.
     */
    public function run(): void
    {
        // Create admin user
        $admin = User::firstOrCreate([
            'email' => 'admin@tanggapdarurat.com'
        ], [
            'name' => 'Administrator',
            'password' => Hash::make('admin123'),
            'role' => 'Admin',
            'last_login_at' => now()
        ]);

        // Create sample warga
        $warga1 = Warga::firstOrCreate([
            'no_ktp' => '3201234567890001'
        ], [
            'nama' => 'Budi Santoso',
            'jenis_kelamin' => 'Laki-laki',
            'agama' => 'Islam',
            'pekerjaan' => 'Wiraswasta',
            'alamat' => 'Jl. Merdeka No. 123, Jakarta',
            'rt' => '001',
            'rw' => '005',
            'telp' => '081234567890',
            'email' => 'budi@email.com'
        ]);

        $warga2 = Warga::firstOrCreate([
            'no_ktp' => '3201234567890002'
        ], [
            'nama' => 'Siti Nurhaliza',
            'jenis_kelamin' => 'Perempuan',
            'agama' => 'Islam',
            'pekerjaan' => 'Guru',
            'alamat' => 'Jl. Pendidikan No. 456, Jakarta',
            'rt' => '002',
            'rw' => '005',
            'telp' => '081234567891',
            'email' => 'siti@email.com'
        ]);

        // Create sample kejadian
        $kejadian1 = KejadianBencana::firstOrCreate([
            'jenis_bencana' => 'Banjir',
            'tanggal' => '2024-12-01'
        ], [
            'lokasi_text' => 'Kelurahan Cipinang Melayu',
            'rt' => '003',
            'rw' => '007',
            'status_kejadian' => 'Verifikasi',
            'keterangan' => 'Banjir akibat hujan deras selama 6 jam'
        ]);

        $kejadian2 = KejadianBencana::firstOrCreate([
            'jenis_bencana' => 'Kebakaran',
            'tanggal' => '2024-12-05'
        ], [
            'lokasi_text' => 'Kelurahan Kebon Jeruk',
            'rt' => '001',
            'rw' => '003',
            'status_kejadian' => 'Selesai',
            'keterangan' => 'Kebakaran rumah warga, sudah ditangani'
        ]);

        // Create sample posko
        $posko1 = PoskoBencana::firstOrCreate([
            'nama' => 'Posko Banjir Cipinang'
        ], [
            'kejadian_id' => $kejadian1->kejadian_id,
            'alamat' => 'Jl. Cipinang Raya No. 100',
            'kontak' => '021-12345678',
            'penanggung_jawab' => 'Pak RT Sumarno'
        ]);

        // Create sample donasi
        $donasi1 = DonasiBencana::firstOrCreate([
            'donatur_nama' => 'PT. Peduli Sesama'
        ], [
            'kejadian_id' => $kejadian1->kejadian_id,
            'jenis' => 'uang',
            'nilai' => 5000000
        ]);

        $donasi2 = DonasiBencana::firstOrCreate([
            'donatur_nama' => 'Komunitas Relawan'
        ], [
            'kejadian_id' => $kejadian1->kejadian_id,
            'jenis' => 'barang',
            'nilai' => null
        ]);

        // Create sample logistik
        $logistik1 = LogistikBencana::firstOrCreate([
            'nama_barang' => 'Beras'
        ], [
            'kejadian_id' => $kejadian1->kejadian_id,
            'satuan' => 'Kg',
            'stok' => 500,
            'sumber' => 'Donasi Masyarakat'
        ]);

        $logistik2 = LogistikBencana::firstOrCreate([
            'nama_barang' => 'Air Mineral'
        ], [
            'kejadian_id' => $kejadian1->kejadian_id,
            'satuan' => 'Botol',
            'stok' => 1000,
            'sumber' => 'Pembelian'
        ]);

        $logistik3 = LogistikBencana::firstOrCreate([
            'nama_barang' => 'Selimut'
        ], [
            'kejadian_id' => $kejadian1->kejadian_id,
            'satuan' => 'Pcs',
            'stok' => 8, // Stok menipis untuk testing
            'sumber' => 'Donasi'
        ]);

        // Create sample distribusi
        DistribusiLogistik::firstOrCreate([
            'logistik_id' => $logistik1->logistik_id,
            'posko_id' => $posko1->posko_id,
            'tanggal' => '2024-12-02'
        ], [
            'jumlah' => 100,
            'penerima' => 'Warga Terdampak RT 003'
        ]);

        DistribusiLogistik::firstOrCreate([
            'logistik_id' => $logistik2->logistik_id,
            'posko_id' => $posko1->posko_id,
            'tanggal' => '2024-12-02'
        ], [
            'jumlah' => 200,
            'penerima' => 'Keluarga Korban Banjir'
        ]);

        $this->command->info('✓ Production seeder completed successfully!');
        $this->command->info('✓ Admin user: admin@tanggapdarurat.com / admin123');
        $this->command->info('✓ Sample data created for all modules');
    }
}