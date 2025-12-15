<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            CreateWargaDummy::class,
            CreateKejadianDummy::class,
            CreatePoskoDummy::class,
            CreateDonasiDummy::class,
            CreateLogistikDummy::class,
            CreateDistribusiDummy::class,
        ]);
    }
}
