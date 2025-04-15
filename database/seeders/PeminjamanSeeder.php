<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Peminjaman;
use App\Models\Pengguna;
use Faker\Factory as Faker;

class PeminjamanSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();
        $penggunaIds = Pengguna::pluck('pengguna_id')->toArray();
        $batchSize = 500;
        $total = 50000;

        for ($i = 0; $i < $total; $i += $batchSize) {
            $data = [];
            for ($j = 0; $j < $batchSize && ($i + $j) < $total; $j++) {
                $tanggalPinjam = $faker->dateTimeBetween('-1 year', 'now');
                $tanggalKembali = $faker->boolean(70) ? $faker->dateTimeBetween($tanggalPinjam, '+7 days') : null;
                $data[] = [
                    'pengguna_id' => $faker->randomElement($penggunaIds),
                    'tanggal_pinjam' => $tanggalPinjam,
                    'tanggal_kembali' => $tanggalKembali,
                    'status' => $tanggalKembali ? 'Dikembalikan' : $faker->randomElement(['Dipinjam', 'Terlambat']),
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
            Peminjaman::insert($data);
        }
    }
}