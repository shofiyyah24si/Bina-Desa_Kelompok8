<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CreateLogistikDummy extends Seeder
{
    public function run()
    {
        $kejadian = DB::table('kejadian_bencana')->pluck('kejadian_id');
        $barang = ['Beras', 'Air Mineral', 'Selimut', 'Perban', 'Mie Instan'];

        foreach (range(1, 10) as $i) {
            DB::table('logistik_bencana')->insert([
                'kejadian_id' => $kejadian->random(),
                'nama_barang' => $barang[array_rand($barang)],
                'satuan' => 'Unit',
                'stok' => rand(50, 300),
                'sumber' => 'Donasi Warga / pemerintah',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
