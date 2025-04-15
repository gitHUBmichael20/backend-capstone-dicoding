<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Keranjang;
use App\Models\Pengguna;
use App\Models\Produk;
use Faker\Factory as Faker;

class KeranjangSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();
        $penggunaIds = Pengguna::pluck('pengguna_id')->toArray();
        $produkIds = Produk::pluck('produk_id')->toArray();
        $batchSize = 500;
        $total = 50000;

        for ($i = 0; $i < $total; $i += $batchSize) {
            $data = [];
            for ($j = 0; $j < $batchSize && ($i + $j) < $total; $j++) {
                $data[] = [
                    'pengguna_id' => $faker->randomElement($penggunaIds),
                    'produk_id' => $faker->randomElement($produkIds),
                    'jumlah' => $faker->numberBetween(1, 10),
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
            Keranjang::insert($data);
        }
    }
}
