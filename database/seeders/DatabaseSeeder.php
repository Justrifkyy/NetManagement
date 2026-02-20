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
        // 4. TAMBAHAN 10 DATA LEADS (VARIASI LENGKAP)
        // ==========================================

        // 1. Prospek Baru - Personal (Ibu Rumah Tangga)
        Lead::create([
            'marketing_id' => $marketing->id,
            'name' => 'Siti Aminah',
            'phone' => '081344556677',
            'email' => 'siti.aminah@gmail.com',
            'customer_type' => 'personal',
            'emergency_name' => 'Pak Rahmat (Suami)',
            'emergency_phone' => '081399887766',
            'emergency_relation' => 'Suami/Istri',
            'address_ktp' => 'Jl. Perintis Kemerdekaan KM 10',
            'address_installation' => 'Perumahan Dosen Unhas Blok AB No. 3',
            'city' => 'Makassar',
            'district' => 'Tamalanrea',
            'coordinates' => '-5.132456, 119.489123',
            'package_id' => $paketBasic->id,
            'status' => 'prospek',
            'source' => 'Facebook Ads',
            'notes_summary' => 'Tanya promo pasang gratis, mau pasang buat anak kuliah.',
        ]);

        // 2. Survey - Bisnis (Cafe)
        Lead::create([
            'marketing_id' => $marketing->id,
            'name' => 'Andi Baso',
            'phone' => '081211223344',
            'customer_type' => 'business',
            'business_name' => 'Cafe Kopi Kita',
            'emergency_name' => 'Manager Toko',
            'emergency_phone' => '081255667788',
            'emergency_relation' => 'Rekan Kerja',
            'address_ktp' => 'Jl. Boulevard Raya No. 55',
            'address_installation' => 'Jl. Pengayoman Ruko Mirah No. 8',
            'city' => 'Makassar',
            'district' => 'Panakkukang',
            'coordinates' => '-5.156789, 119.445678',
            'package_id' => $paketSuper->id,
            'status' => 'survey',
            'survey_date' => now()->addDays(1),
            'preferred_time' => 'Pagi jam 09.00',
            'source' => 'Kanvasing',
            'notes_summary' => 'Butuh wifi kencang untuk pelanggan cafe, minta 2 router jika bisa.',
        ]);

        // 3. Instalasi - Personal (Gamer)
        Lead::create([
            'marketing_id' => $marketing->id,
            'name' => 'Kevin Sanjaya',
            'phone' => '082188990011',
            'email' => 'kevin.gaming@yahoo.com',
            'customer_type' => 'personal',
            'emergency_name' => 'Mama Kevin',
            'emergency_phone' => '082177665544',
            'emergency_relation' => 'Orang Tua',
            'address_ktp' => 'Jl. Sungai Saddang Baru',
            'address_installation' => 'Jl. Sungai Saddang Baru Lrg. 5 No. 12',
            'city' => 'Makassar',
            'district' => 'Rappocini',
            'coordinates' => '-5.161234, 119.423456',
            'package_id' => $paketSuper->id,
            'status' => 'instalasi',
            'source' => 'Instagram',
            'survey_date' => now()->subDays(1),
            'installation_date' => now()->addDays(2),
            'notes_summary' => 'Pastikan ping rendah untuk main Valorant.',
        ]);

        // 4. Prospek - Personal (Ragu-ragu)
        Lead::create([
            'marketing_id' => $marketing->id,
            'name' => 'Rini Anggraeni',
            'phone' => '085233445566',
            'customer_type' => 'personal',
            'emergency_name' => 'Kakak Rini',
            'emergency_phone' => '085299887766',
            'emergency_relation' => 'Saudara',
            'address_ktp' => 'Jl. Dg. Tata Raya',
            'address_installation' => 'Jl. Dg. Tata 1 Blok 3',
            'city' => 'Makassar',
            'district' => 'Tamalate',
            'coordinates' => '-5.189012, 119.412345',
            'package_id' => $paketBasic->id,
            'status' => 'prospek',
            'source' => 'Brosur',
            'notes_obstacle' => 'Masih bandingkan harga dengan provider sebelah (Indihome).',
            'notes_summary' => 'Belum deal, minta ditelepon lagi minggu depan.',
        ]);

        // 5. Batal - Personal (Kendala Izin)
        Lead::create([
            'marketing_id' => $marketing->id,
            'name' => 'Pak Haji Amir',
            'phone' => '0811445566',
            'customer_type' => 'personal',
            'emergency_name' => 'Anak Pak Haji',
            'emergency_phone' => '0811556677',
            'emergency_relation' => 'Anak',
            'address_ktp' => 'Jl. Veteran Selatan',
            'address_installation' => 'Jl. Veteran Selatan Lrg. 8',
            'city' => 'Makassar',
            'district' => 'Mamajang',
            'package_id' => $paketBasic->id,
            'status' => 'batal',
            'source' => 'Teman',
            'notes_obstacle' => 'Tidak diizinkan pemilik kos tarik kabel.',
            'notes_summary' => 'Cancel karena kendala teknis lapangan.',
        ]);

        // 6. Aktif - Bisnis (Laundry)
        Lead::create([
            'marketing_id' => $marketing->id,
            'name' => 'Ibu Wati',
            'phone' => '081311223399',
            'customer_type' => 'business',
            'business_name' => 'Wati Laundry & Dry Clean',
            'emergency_name' => 'Suami Ibu Wati',
            'emergency_phone' => '081322334455',
            'emergency_relation' => 'Suami/Istri',
            'address_ktp' => 'Jl. Toddopuli Raya',
            'address_installation' => 'Ruko Toddopuli Timur No. 10',
            'city' => 'Makassar',
            'district' => 'Panakkukang',
            'coordinates' => '-5.165432, 119.456789',
            'package_id' => $paketBasic->id,
            'status' => 'aktif', // Sudah jadi pelanggan
            'source' => 'Spanduk Jalan',
            'installation_date' => now()->subMonth(),
            'notes_summary' => 'Pelanggan lama, pembayaran lancar.',
        ]);

        // 7. Survey - Personal (Pindahan Rumah)
        Lead::create([
            'marketing_id' => $marketing->id,
            'name' => 'Bambang Pamungkas',
            'phone' => '081299887700',
            'email' => 'bambang.p@gmail.com',
            'customer_type' => 'personal',
            'emergency_name' => 'Istri Bambang',
            'emergency_phone' => '081200998877',
            'emergency_relation' => 'Suami/Istri',
            'address_ktp' => 'Jakarta (KTP Luar)',
            'address_installation' => 'Kompleks Citraland Hertasning Cluster A',
            'city' => 'Gowa',
            'district' => 'Somba Opu',
            'coordinates' => '-5.201234, 119.467890',
            'package_id' => $paketSuper->id,
            'status' => 'survey',
            'survey_date' => now()->addDays(2),
            'preferred_time' => 'Sore setelah pulang kerja',
            'source' => 'Google Search',
            'notes_summary' => 'Baru pindah rumah, butuh pasang cepat.',
        ]);

        // 8. Instalasi - Bisnis (Warnet)
        Lead::create([
            'marketing_id' => $marketing->id,
            'name' => 'Ko Michael',
            'phone' => '089988776655',
            'customer_type' => 'business',
            'business_name' => 'CyberNet Game Center',
            'emergency_name' => 'Admin Warnet',
            'emergency_phone' => '089977665544',
            'emergency_relation' => 'Karyawan',
            'address_ktp' => 'Jl. Sulawesi',
            'address_installation' => 'Jl. Urip Sumoharjo No. 99',
            'city' => 'Makassar',
            'district' => 'Makassar',
            'coordinates' => '-5.143210, 119.421098',
            'package_id' => $paketSuper->id,
            'status' => 'instalasi',
            'source' => 'Referensi Teknisi',
            'installation_date' => now()->addDays(3),
            'notes_special' => 'Minta IP Public Static jika ada.',
            'notes_summary' => 'Deal paket tertinggi.',
        ]);

        // 9. Prospek - Personal (Tanya-tanya)
        Lead::create([
            'marketing_id' => $marketing->id,
            'name' => 'Putri Ayu',
            'phone' => '087711223344',
            'customer_type' => 'personal',
            'emergency_name' => 'Ayah Putri',
            'emergency_phone' => '087755667788',
            'emergency_relation' => 'Orang Tua',
            'address_ktp' => 'Jl. Rajawali',
            'address_installation' => 'Jl. Rajawali Lrg. 10',
            'city' => 'Makassar',
            'district' => 'Mariso',
            'package_id' => $paketBasic->id,
            'status' => 'prospek',
            'source' => 'WhatsApp Blast',
            'notes_summary' => 'Baru tanya harga, belum yakin mau pasang kapan.',
        ]);

        // 10. Survey - Personal (Kost Mahasiswa)
        Lead::create([
            'marketing_id' => $marketing->id,
            'name' => 'Dimas Anggara',
            'phone' => '085311223344',
            'customer_type' => 'personal',
            'emergency_name' => 'Teman Kost',
            'emergency_phone' => '085399887766',
            'emergency_relation' => 'Teman',
            'address_ktp' => 'Palopo (KTP Daerah)',
            'address_installation' => 'Pondok Indah 2, Jl. Sahabat (Belakang Unhas)',
            'city' => 'Makassar',
            'district' => 'Tamalanrea',
            'coordinates' => '-5.135678, 119.491234',
            'package_id' => $paketBasic->id,
            'status' => 'survey',
            'survey_date' => now()->addDays(1),
            'notes_obstacle' => 'Harus izin ibu kost dulu untuk tarik kabel.',
            'notes_summary' => 'Mahasiswa butuh buat skripsi.',
        ]);    
    }
}
