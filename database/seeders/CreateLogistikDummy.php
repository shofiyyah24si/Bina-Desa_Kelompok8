<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CreateLogistikDummy extends Seeder
{
    public function run()
    {
        // Ambil kejadian_id yang ada
        $kejadianIds = DB::table('kejadian_bencana')->pluck('kejadian_id');

        if ($kejadianIds->isEmpty()) {
            $this->command->warn('Tidak ada data kejadian_bencana. Seeder Logistik dilewati.');
            return;
        }

        $barangList = [
            'Beras',
            'Air Mineral',
            'Selimut',
            'Perban',
            'Mie Instan'
        ];

        // ⬇️ MASUKKAN 5 DATA SAJA
        for ($i = 1; $i <= 5; $i++) {
            DB::table('logistik_bencana')->insert([
                'kejadian_id' => $kejadianIds->random(),
                'nama_barang' => $barangList[array_rand($barangList)],
                'satuan'      => 'Unit',
                'stok'        => rand(50, 300),
                'sumber'      => 'Donasi Warga / Pemerintah',
                'created_at'  => now(),
                'updated_at'  => now(),
            ]);
        }

        $this->command->info('Seeder Logistik Bencana berhasil (5 data).');
    }
}
