<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\DetailPeminjaman;
use App\Models\Peminjaman;
use App\Models\Produk;
use Faker\Factory as Faker;

class DetailPeminjamanSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();
        $peminjamanIds = Peminjaman::pluck('peminjaman_id')->toArray();
        $produkIds = Produk::pluck('produk_id')->toArray();
        $batchSize = 500;
        $total = 50000;

        for ($i = 0; $i < $total; $i += $batchSize) {
            $data = [];
            for ($j = 0; $j < $batchSize && ($i + $j) < $total; $j++) {
                $data[] = [
                    'peminjaman_id' => $faker->randomElement($peminjamanIds),
                    'produk_id' => $faker->randomElement($produkIds),
                    'jumlah' => $faker->numberBetween(1, 5),
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
            DetailPeminjaman::insert($data);
        }
    }
}
