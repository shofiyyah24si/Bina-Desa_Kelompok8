<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;
use App\Models\KejadianBencana;

class CreateDonasiDummy extends Seeder
{
    public function run()
    {
        $faker = Faker::create('id_ID');

        // Ambil kejadian_id yang ada
        $kejadianIds = KejadianBencana::pluck('kejadian_id')->toArray();

        if (empty($kejadianIds)) {
            $this->command->warn('Tidak ada data kejadian_bencana. Seeder Donasi dilewati.');
            return;
        }

        $jenisList = [
            'Uang',
            'Barang',
            'Pakaian',
            'Makanan',
            'Obat-obatan',
            'Peralatan'
        ];

        // ⬇️ MASUKKAN 5 DATA SAJA
        for ($i = 1; $i <= 5; $i++) {
            DB::table('donasi_bencana')->insert([
                'kejadian_id'    => $faker->randomElement($kejadianIds),
                'donatur_nama'   => $faker->name,
                'jenis'          => $faker->randomElement($jenisList),
                'nilai'          => $faker->numberBetween(50000, 3000000),
                'tanggal_donasi' => $faker->date(), // ⬅️ DATE (AMAN)
                'created_at'     => now(),
                'updated_at'     => now(),
            ]);
        }

        $this->command->info('Seeder Donasi Bencana berhasil (5 data).');
    }
}
