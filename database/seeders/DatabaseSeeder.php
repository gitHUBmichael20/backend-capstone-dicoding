<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            ProdukSeeder::class,
            PenggunaSeeder::class,
            PeminjamanSeeder::class,
            DetailPeminjamanSeeder::class,
            KeranjangSeeder::class,
        ]);
    }
}
