<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Package;
use App\Models\Lead; // Jangan lupa import model Lead
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ==========================================
        // 1. DATA PENGGUNA (USERS)
        // ==========================================

        // Super Admin
        User::create([
            'name' => 'Big Boss (Owner)',
            'email' => 'owner@netmanager.local',
            'password' => Hash::make('password'),
            'role' => 'super_admin',
            'marketing_code' => 'OWNER01',
            'email_verified_at' => now(),
        ]);

        // Admin Operasional
        User::create([
            'name' => 'Admin Operasional',
            'email' => 'admin@netmanager.local',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);

        // Marketing
        $marketing = User::create([
            'name' => 'Staf Marketing',
            'email' => 'marketing@netmanager.local',
            'password' => Hash::make('password'),
            'role' => 'marketing',
            'marketing_code' => 'SALES01', // Kode sales untuk referral
            'email_verified_at' => now(),
        ]);

        // Teknisi
        User::create([
            'name' => 'Teknisi Lapangan',
            'email' => 'teknisi@netmanager.local',
            'password' => Hash::make('password'),
            'role' => 'technician',
            'email_verified_at' => now(),
        ]);

        // Pelanggan Contoh
        User::create([
            'name' => 'Pelanggan Setia',
            'email' => 'customer@netmanager.local',
            'password' => Hash::make('password'),
            'role' => 'customer',
            'email_verified_at' => now(),
        ]);

        // ==========================================
        // 2. DATA PAKET INTERNET (PACKAGES)
        // ==========================================

        $paketBasic = Package::create([
            'name' => 'Home Basic 10 Mbps',
            'price' => 150000,
            'speed_mbps' => 10,
            'description' => 'Cocok untuk penggunaan ringan, browsing, dan chat.',
            'installation_fee' => 100000,
        ]);

        $paketSuper = Package::create([
            'name' => 'Home Super 50 Mbps',
            'price' => 350000,
            'speed_mbps' => 50,
            'description' => 'Cocok untuk gaming, streaming 4K, dan WFH.',
            'installation_fee' => 0, // Promo gratis pasang
        ]);

        // ==========================================
        // 3. DATA LEADS / PROSPEK (DUMMY DATA)
        // ==========================================

        // A. Lead Status: PROSPEK BARU (Perorangan)
        Lead::create([
            'marketing_id' => $marketing->id,
            'name' => 'Budi Santoso',
            'phone' => '081234567890',
            'email' => 'budi@gmail.com',
            'customer_type' => 'personal',
            'emergency_name' => 'Siti (Istri)',
            'emergency_phone' => '081298765432',
            'emergency_relation' => 'Suami/Istri',

            // Alamat
            'address_ktp' => 'Jl. Merpati No. 10, RT 01/RW 02',
            'address_installation' => 'Jl. Merpati No. 10, RT 01/RW 02, Kel. Maju Jaya, Kec. Sukamaju',
            'city' => 'Makassar',
            'district' => 'Sukamaju',
            'coordinates' => '-5.147665, 119.432731', // Koordinat contoh
            'landmark' => 'Depan Masjid Al-Ikhlas Pagar Biru',

            'package_id' => $paketBasic->id,
            'status' => 'prospek',
            'source' => 'Iklan Facebook',
            'notes_summary' => 'Tertarik pasang untuk anak sekolah online.',
        ]);

        // B. Lead Status: SURVEY (Bisnis/Usaha)
        Lead::create([
            'marketing_id' => $marketing->id,
            'name' => 'Hendra Wijaya',
            'phone' => '085255566677',
            'customer_type' => 'business',
            'business_name' => 'Warkop Kopi Senja',
            'emergency_name' => 'Rina (Admin)',
            'emergency_phone' => '085211122233',
            'emergency_relation' => 'Kerabat',

            // Alamat
            'address_ktp' => 'Jl. A.P. Pettarani No. 55',
            'address_installation' => 'Ruko Zamrud Blok B No. 5, Jl. Hertasning',
            'city' => 'Makassar',
            'district' => 'Rappocini',
            'coordinates' => '-5.173872, 119.442994',

            'package_id' => $paketSuper->id,
            'status' => 'survey',
            'source' => 'Referensi Teman',
            'survey_date' => now()->addDays(1), // Besok
            'preferred_time' => 'Siang jam 14.00',
            'notes_summary' => 'Butuh koneksi stabil untuk pelanggan warkop.',
        ]);

        // C. Lead Status: INSTALASI (Siap Dipasang)
        Lead::create([
            'marketing_id' => $marketing->id,
            'name' => 'Dewi Sartika',
            'phone' => '081122334455',
            'customer_type' => 'personal',
            'emergency_name' => 'Ibu Ratna',
            'emergency_phone' => '081199887766',
            'emergency_relation' => 'Orang Tua',

            // Alamat
            'address_ktp' => 'Jl. Cendrawasih No. 20',
            'address_installation' => 'Jl. Cendrawasih No. 20, Lorong 3',
            'city' => 'Makassar',
            'coordinates' => '-5.155321, 119.412345',
            'landmark' => 'Rumah cat hijau tingkat 2',

            'package_id' => $paketSuper->id,
            'status' => 'instalasi',
            'source' => 'Brosur',
            'survey_date' => now()->subDays(2), // Survey sudah lewat
            'installation_date' => now()->addDays(2), // Jadwal pasang lusa
            'notes_summary' => 'Sudah deal harga, minta kabel dirapikan.',
        ]);
    }
}
