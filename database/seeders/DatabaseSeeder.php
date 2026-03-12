<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Package;
use App\Models\Lead;
use App\Models\Customer;
use App\Models\Subscription;
use App\Models\Invoice;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ==========================================
        // 1. DATA PENGGUNA (PEGAWAI)
        // ==========================================
        $superAdmin = User::create([
            'name' => 'Big Boss (Owner)',
            'email' => 'owner@netmanager.local',
            'password' => Hash::make('password'),
            'role' => 'super_admin',
            'marketing_code' => 'OWNER01',
            'email_verified_at' => now(),
        ]);

        $admin = User::create([
            'name' => 'Admin Operasional',
            'email' => 'admin@netmanager.local',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);

        $marketing = User::create([
            'name' => 'Staf Marketing',
            'email' => 'marketing@netmanager.local',
            'password' => Hash::make('password'),
            'role' => 'marketing',
            'marketing_code' => 'SALES01',
            'email_verified_at' => now(),
        ]);

        $teknisi = User::create([
            'name' => 'Teknisi Lapangan',
            'email' => 'teknisi@netmanager.local',
            'password' => Hash::make('password'),
            'role' => 'technician',
            'email_verified_at' => now(),
        ]);

        // ==========================================
        // 2. DATA PAKET INTERNET
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
            'installation_fee' => 0,
        ]);

        // ==========================================
        // 3. SIMULASI PELANGGAN AKTIF (BISA LOGIN & BAYAR)
        // ==========================================

        // A. Buat Akun Login untuk Pelanggan
        $userCustomer = User::create([
            'name' => 'JustRifkyy', // Nama Pelanggan
            'email' => 'customer@netmanager.local', // Email Login Pelanggan
            'password' => Hash::make('password'), // Password Login Pelanggan
            'role' => 'customer',
            'email_verified_at' => now(),
        ]);

        // B. Buat Riwayat Prospek (Seolah-olah dari awal)
        $leadAktif = Lead::create([
            'marketing_id' => $marketing->id,
            'name' => 'JustRifkyy',
            'phone' => '081234567890',
            'email' => 'customer@netmanager.local',
            'customer_type' => 'personal',
            'emergency_name' => 'Bapak',
            'emergency_phone' => '081299998888',
            'emergency_relation' => 'Orang Tua',
            'address_ktp' => 'Jl. Perintis Kemerdekaan KM 10',
            'address_installation' => 'Asrama UMI, Kamar 101',
            'city' => 'Makassar',
            'district' => 'Tamalanrea',
            'package_id' => $paketSuper->id,
            'status' => 'aktif',
            'source' => 'Website',
        ]);

        // C. Buat Profil Pelanggan Resmi
        $customerProfile = Customer::create([
            'user_id' => $userCustomer->id,
            'lead_id' => $leadAktif->id,
            'customer_code' => 'CUST-' . date('Ymd') . '-001', // <--- TAMBAHKAN BARIS INI
            'phone_number' => $leadAktif->phone,
            'address_installation' => $leadAktif->address_installation,
            'coordinates' => $leadAktif->coordinates,
        ]);

        // D. Buat Langganan Internet (Subscription)
        $subscription = Subscription::create([
            'customer_id' => $customerProfile->id,
            'package_id' => $paketSuper->id,
            'pppoe_username' => 'rifkyy_umi_01',
            'pppoe_password' => 'secret123',
            'installation_date' => now()->subDays(5),
            'billing_due_date' => 5, // Jatuh tempo setiap tanggal 5
            'status' => 'active',
        ]);

        // E. Buat 1 Tagihan yang Belum Lunas (Unpaid)
        Invoice::create([
            'subscription_id' => $subscription->id,
            'invoice_number' => 'INV-' . date('Ymd') . '-0001',
            'amount' => $paketSuper->price,
            'status' => 'unpaid',
            'due_date' => now()->addDays(2),
        ]);

        // ==========================================
        // 4. TAMBAHAN 9 DATA LEADS (MURNI PROSPEK - BELUM PUNYA AKUN)
        // ==========================================

        Lead::create([
            'marketing_id' => $marketing->id,
            'name' => 'Siti Aminah',
            'phone' => '081344556677',
            'email' => 'siti.aminah@gmail.com',
            'customer_type' => 'personal',
            'emergency_name' => 'Pak Rahmat',
            'emergency_phone' => '081399887766',
            'emergency_relation' => 'Suami',
            'address_ktp' => 'Jl. Daya',
            'address_installation' => 'Perumahan BTP Blok M No 22',
            'city' => 'Makassar',
            'district' => 'Biringkanaya',
            'package_id' => $paketBasic->id,
            'status' => 'prospek',
            'source' => 'Facebook Ads',
        ]);

        Lead::create([
            'marketing_id' => $marketing->id,
            'name' => 'Cafe Kopi Kita',
            'phone' => '081211223344',
            'email' => 'ckk@gmail.com',
            'customer_type' => 'business',
            'business_name' => 'Cafe Kopi Kita',
            'emergency_name' => 'Manager Toko',
            'emergency_phone' => '081255667788',
            'emergency_relation' => 'Rekan Kerja',
            'address_ktp' => 'Jl. Boulevard Raya No. 55',
            'address_installation' => 'Jl. Pengayoman Ruko Mirah No. 8',
            'city' => 'Makassar',
            'district' => 'Panakkukang',
            'package_id' => $paketSuper->id,
            'status' => 'survey',
            'survey_date' => now()->addDays(1),
            'source' => 'Kanvasing',
        ]);

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
            'package_id' => $paketSuper->id,
            'status' => 'instalasi',
            'source' => 'Instagram',
            'installation_date' => now()->addDays(2),
        ]);

        Lead::create([
            'marketing_id' => $marketing->id,
            'name' => 'Rini Anggraeni',
            'phone' => '085233445566',
            'email' => 'rinih@gmail.com',
            'customer_type' => 'personal',
            'emergency_name' => 'Kakak Rini',
            'emergency_phone' => '085299887766',
            'emergency_relation' => 'Saudara',
            'address_ktp' => 'Jl. Dg. Tata Raya',
            'address_installation' => 'Jl. Dg. Tata 1 Blok 3',
            'city' => 'Makassar',
            'district' => 'Tamalate',
            'package_id' => $paketBasic->id,
            'status' => 'prospek',
            'source' => 'Brosur',
        ]);

        Lead::create([
            'marketing_id' => $marketing->id,
            'name' => 'Pak Haji Amir',
            'email' => 'amir@gmail.com',
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
        ]);

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
            'package_id' => $paketSuper->id,
            'status' => 'survey',
            'survey_date' => now()->addDays(2),
            'source' => 'Google Search',
        ]);

        Lead::create([
            'marketing_id' => $marketing->id,
            'name' => 'CyberNet Game Center',
            'phone' => '089988776655',
            'customer_type' => 'business',
            'email' => 'michael@gmail.com',
            'business_name' => 'CyberNet Game Center',
            'emergency_name' => 'Admin Warnet',
            'emergency_phone' => '089977665544',
            'emergency_relation' => 'Karyawan',
            'address_ktp' => 'Jl. Sulawesi',
            'address_installation' => 'Jl. Urip Sumoharjo No. 99',
            'city' => 'Makassar',
            'district' => 'Makassar',
            'package_id' => $paketSuper->id,
            'status' => 'instalasi',
            'source' => 'Referensi Teknisi',
            'installation_date' => now()->addDays(3),
        ]);

        Lead::create([
            'marketing_id' => $marketing->id,
            'name' => 'Putri Ayu',
            'phone' => '087711223344',
            'email' => 'ayu@gmail.com',
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
        ]);

        Lead::create([
            'marketing_id' => $marketing->id,
            'name' => 'Dimas Anggara',
            'phone' => '085311223344',
            'email' => 'dimas@gmail.com',
            'customer_type' => 'personal',
            'emergency_name' => 'Teman Kost',
            'emergency_phone' => '085399887766',
            'emergency_relation' => 'Teman',
            'address_ktp' => 'Palopo',
            'address_installation' => 'Pondok Indah 2, Jl. Sahabat',
            'city' => 'Makassar',
            'district' => 'Tamalanrea',
            'package_id' => $paketBasic->id,
            'status' => 'survey',
            'survey_date' => now()->addDays(1),
        ]);
    }
}
