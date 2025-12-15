<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CreatePoskoDummy extends Seeder
{
    public function run()
    {
        $kejadian = DB::table('kejadian_bencana')->pluck('kejadian_id');

        foreach ($kejadian as $id) {
            foreach (range(1, 2) as $i) {
                DB::table('posko_bencana')->insert([
                    'kejadian_id' => $id,
                    'nama' => "Posko $i Kejadian $id",
                    'alamat' => "Jl. Posko No.$i",
                    'kontak' => "08" . rand(100000000, 999999999),
                    'penanggung_jawab' => "Penanggung Jawab $i",
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
