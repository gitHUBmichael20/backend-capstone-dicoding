<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $admins = [
            [
                'nama_admin' => 'Admin Satu',
                'email' => 'admin1@gmail.com',
                'password' => 'password1',
            ],
            [
                'nama_admin' => 'Admin Dua',
                'email' => 'admin2@gmail.com',
                'password' => 'password2',
            ],
        ];

        foreach ($admins as $admin) {
            Admin::create($admin);
        }
    }
}
