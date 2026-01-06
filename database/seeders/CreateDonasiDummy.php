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
        
        if (empty($kejadianIds)) {
            echo "No kejadian_bencana records found. Please seed kejadian_bencana first.\n";
            return;
        }

        // Jenis donasi yang sesuai dengan enum atau varchar
        $jenisList = ['uang', 'barang', 'Pakaian', 'Makanan', 'Obat-obatan', 'Peralatan'];

        foreach (range(1, 20) as $i) {
            $data = [
                'kejadian_id'   => $faker->randomElement($kejadianIds),  
                'donatur_nama'  => $faker->name,
                'jenis'         => $faker->randomElement($jenisList),
                'nilai'         => $faker->randomFloat(2, 50000, 3000000),
                'created_at'    => now(),
                'updated_at'    => now(),
            ];
            
            // Check if tanggal_donasi column exists in the table
            try {
                $columns = DB::select("SHOW COLUMNS FROM donasi_bencana LIKE 'tanggal_donasi'");
                if (!empty($columns)) {
                    $data['tanggal_donasi'] = $faker->dateTimeBetween('-1 year', 'now');
                }
            } catch (\Exception $e) {
                // Column doesn't exist, continue without it
            }
            
            try {
                DB::table('donasi_bencana')->insert($data);
                echo "Inserted donasi record " . $i . "\n";
            } catch (\Exception $e) {
                echo "Error inserting donasi record " . $i . ": " . $e->getMessage() . "\n";
            }
        }
        
        echo "Donasi seeding completed.\n";
    }
}
