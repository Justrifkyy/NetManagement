<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Package;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. SUPER ADMIN (Owner/IT) - Akses Full + Kelola User
        User::create([
            'name' => 'Big Boss (Owner)',
            'email' => 'owner@netmanager.local',
            'password' => Hash::make('password'),
            'role' => 'super_admin', // Role Tertinggi
            'email_verified_at' => now(),
        ]);

        // 2. ADMIN (Operasional/Manager) - Akses Full Operasional (No Delete User)
        User::create([
            'name' => 'Admin Operasional',
            'email' => 'admin@netmanager.local',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);

        // 3. Marketing
        User::create([
            'name' => 'Staf Marketing',
            'email' => 'marketing@netmanager.local',
            'password' => Hash::make('password'),
            'role' => 'marketing',
            'email_verified_at' => now(),
        ]);

        // 4. Teknisi
        User::create([
            'name' => 'Teknisi Lapangan',
            'email' => 'teknisi@netmanager.local',
            'password' => Hash::make('password'),
            'role' => 'technician',
            'email_verified_at' => now(),
        ]);

        // 5. Pelanggan
        User::create([
            'name' => 'Pelanggan Setia',
            'email' => 'customer@netmanager.local',
            'password' => Hash::make('password'),
            'role' => 'customer',
            'email_verified_at' => now(),
        ]);

        // Data Paket Internet
        Package::create(['name' => 'Home Basic 10 Mbps', 'price' => 150000, 'speed_mbps' => 10]);
        Package::create(['name' => 'Home Super 50 Mbps', 'price' => 350000, 'speed_mbps' => 50]);
    }
}
