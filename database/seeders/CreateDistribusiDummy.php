<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CreateDistribusiDummy extends Seeder
{
    public function run()
    {
        $logistikIds = DB::table('logistik_bencana')->pluck('logistik_id');
        $poskoIds    = DB::table('posko_bencana')->pluck('posko_id');

        if ($logistikIds->isEmpty() || $poskoIds->isEmpty()) {
            $this->command->warn(
                'Seeder Distribusi dilewati: data logistik_bencana atau posko_bencana belum ada.'
            );
            return;
        }

        // ⬇️ MASUKKAN 5 DATA SAJA
        for ($i = 1; $i <= 5; $i++) {
            DB::table('distribusi_logistik')->insert([
                'logistik_id' => $logistikIds->random(),
                'posko_id'    => $poskoIds->random(),
                'tanggal'     => now()->subDays(rand(1, 10))->toDateString(), // DATE
                'jumlah'      => rand(5, 30),
                'penerima'    => 'Warga penerima ' . $i,
                'created_at'  => now(),
                'updated_at'  => now(),
            ]);
        }

        $this->command->info('Seeder Distribusi Logistik berhasil (5 data).');
    }
}
