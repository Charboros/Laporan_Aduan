<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Akun Admin
        User::create([
            'name' => 'Administrator Sistem',
            'email' => 'admin@admas.local',
            'password' => Hash::make('password123'),
            'role' => 'admin',
        ]);

        // 2. Akun Petugas
        User::create([
            'name' => 'Petugas Pelayanan',
            'email' => 'petugas@admas.local',
            'password' => Hash::make('password123'),
            'role' => 'petugas',
        ]);

        // 3. Akun Kepala Bidang
        User::create([
            'name' => 'Kepala Bidang',
            'email' => 'kabid@admas.local',
            'password' => Hash::make('password123'),
            'role' => 'kepala_bidang',
        ]);
    }
}