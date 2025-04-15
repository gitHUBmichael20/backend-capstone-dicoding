<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;

class PenggunaSeeder extends Seeder
{
    public function run(): void
    {
        // Disable query logging to reduce memory usage
        DB::disableQueryLog();

        $faker = Faker::create('id_ID');
        $batchSize = 100; // Increased to 100 for faster inserts
        $totalRecords = 50000;
        $data = [];
        $reportInterval = 10; // Report every 10 records

        for ($i = 0; $i < $totalRecords; $i++) {
            $data[] = [
                'nama_pengguna' => $faker->name,
                'alamat' => $faker->address,
                'nomor_telepon' => $faker->phoneNumber,
                'email' => $faker->unique()->safeEmail,
                'email_verified_at' => $faker->dateTimeBetween('-10 years', 'now'),
                'password' => Hash::make('password123'),
                'remember_token' => $faker->md5,
                'created_at' => $faker->dateTimeBetween('-10 years', 'now'),
                'updated_at' => now()
            ];

            // Insert when batch is full
            if (count($data) === $batchSize) {
                DB::table('pengguna')->insert($data);
                $data = []; // Clear the array
            }

            // Report progress every 10 records
            if (($i + 1) % $reportInterval === 0) {
                $this->command->info("Seeded pengguna: " . ($i + 1) . " records");
            }
        }

        // Insert any remaining records
        if (!empty($data)) {
            DB::table('pengguna')->insert($data);
            $this->command->info("Seeded pengguna: $totalRecords records (final batch)");
        }

        // Re-enable query logging if needed
        DB::enableQueryLog();
    }
}
