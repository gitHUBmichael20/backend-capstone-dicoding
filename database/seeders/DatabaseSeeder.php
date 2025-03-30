<?php

namespace Database\Seeders;

use App\Models\Pengguna;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
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
