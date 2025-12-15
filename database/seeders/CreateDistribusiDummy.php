<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CreateDistribusiDummy extends Seeder
{
    public function run()
    {
        $logistik = DB::table('logistik_bencana')->pluck('logistik_id');
        $posko = DB::table('posko_bencana')->pluck('posko_id');

        foreach (range(1, 10) as $i) {
            DB::table('distribusi_logistik')->insert([
                'logistik_id' => $logistik->random(),
                'posko_id' => $posko->random(),
                'tanggal' => Carbon::now()->subDays(rand(1, 10)),
                'jumlah' => rand(5, 30),
                'penerima' => "Warga penerima $i",
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
