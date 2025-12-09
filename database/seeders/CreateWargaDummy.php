<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class CreateWargaDummy extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('id_ID'); // lokal Indonesia

        foreach (range(1, 100) as $index) {
            DB::table('warga')->insert([
                'no_ktp'        => $faker->unique()->numerify('3276##########'), // 16 digit
                'nama'          => $faker->name,
                'jenis_kelamin' => $faker->randomElement(['Laki-laki', 'Perempuan']),
                'agama'         => $faker->randomElement(['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha', 'Konghucu']),
                'pekerjaan'     => $faker->jobTitle,
                'telp'          => $faker->phoneNumber,
                'email'         => $faker->unique()->safeEmail,
                'foto_profil'   => null, // bisa null karena upload opsional
                'created_at'    => now(),
                'updated_at'    => now(),
            ]);
        }
    }
}
