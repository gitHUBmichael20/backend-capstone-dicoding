<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Admin::create([
            'nama_admin' => 'Admin1',
            'email' => 'admin1@gmail.com',
            'password' => 'password123', // Akan di-hash otomatis oleh mutator setPasswordAttribute
        ]);

        Admin::create([
            'nama_admin' => 'Admin2',
            'email' => 'admin2@gmail.com',
            'password' => 'password123', // Akan di-hash otomatis oleh mutator setPasswordAttribute
        ]);
    }
}
