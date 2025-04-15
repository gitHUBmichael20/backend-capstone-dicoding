<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // User::factory(10)->create();

        Pengguna::factory()->create([
            'nama_pengguna' => 'q',
            'email' => 'q@gmail.com',
            'nomor_telepon' => '62878xxxxxxxx',
            'password' => 'qqqqqqqq',
        ]);
        $this->call([
            AdminSeeder::class,
            ProdukSeeder::class,
        ]);
    }
}
