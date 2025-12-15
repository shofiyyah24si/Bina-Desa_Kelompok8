<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class CreateKejadianDummy extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        $jenisList = [
            'Banjir', 'Kebakaran', 'Tanah Longsor', 'Angin Puting Beliung',
            'Gempa Bumi', 'Tsunami', 'Kekeringan', 'Kecelakaan'
        ];

        $statusList = [
            'Dilaporkan', 'Diproses', 'Verifikasi', 'Selesai'
        ];

        foreach (range(1, 20) as $i) {
            DB::table('kejadian_bencana')->insert([
                'jenis_bencana'   => $faker->randomElement($jenisList),
                'tanggal'         => $faker->dateTimeBetween('-1 years', 'now')->format('Y-m-d'),
                'lokasi_text'     => $faker->address,
                'rt'              => strval($faker->numberBetween(1, 10)),
                'rw'              => strval($faker->numberBetween(1, 5)),
                'dampak'          => $faker->sentence(3),
                'status_kejadian' => $faker->randomElement($statusList),
                'keterangan'      => $faker->sentence(8),
                'created_at'      => now(),
                'updated_at'      => now(),
            ]);
        }
    }
}
