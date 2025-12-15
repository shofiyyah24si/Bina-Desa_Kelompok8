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

        // Ambil semua kejadian_id yang valid
        $kejadianIds = KejadianBencana::pluck('kejadian_id')->toArray();

        $jenisList = ['Uang', 'Pakaian', 'Makanan', 'Obat-obatan', 'Peralatan'];

        foreach (range(1, 20) as $i) {
            DB::table('donasi_bencana')->insert([
                'kejadian_id'   => $faker->randomElement($kejadianIds),  // <- AMAN
                'donatur_nama'  => $faker->name,
                'jenis'         => $faker->randomElement($jenisList),
                'nilai'         => $faker->randomFloat(2, 50000, 3000000),
                'created_at'    => now(),
                'updated_at'    => now(),
            ]);
        }
    }
}
