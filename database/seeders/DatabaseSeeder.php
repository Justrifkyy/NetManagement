<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\MasterArea;
use App\Models\Package;
use App\Models\NetworkAsset;
use App\Models\Lead;
use App\Models\Customer;
use App\Models\Subscription;
use App\Models\Invoice;
use App\Models\Ticket;
use App\Models\SystemSetting;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ==========================================
        // 0. DATA PENGATURAN SISTEM (SYSTEM SETTINGS)
        // ==========================================
        $settings = [
            ['key' => 'app_name', 'value' => 'NetManager ISP', 'description' => 'Nama Aplikasi'],
            ['key' => 'company_name', 'value' => 'PT Jaringan Nusantara', 'description' => 'Nama Perusahaan'],
            ['key' => 'company_phone', 'value' => '0411-123456', 'description' => 'Telepon Perusahaan'],
            ['key' => 'company_email', 'value' => 'cs@netmanager.local', 'description' => 'Email Perusahaan'],
            ['key' => 'company_address', 'value' => 'Jl. AP Pettarani, Makassar', 'description' => 'Alamat Perusahaan'],
            ['key' => 'maintenance_mode', 'value' => '0', 'description' => 'Mode Perbaikan'],
            ['key' => 'timezone', 'value' => 'Asia/Makassar', 'description' => 'Zona Waktu'],
            ['key' => 'currency', 'value' => 'IDR', 'description' => 'Mata Uang'],
            ['key' => 'enable_two_factor', 'value' => '0', 'description' => 'Wajib 2FA'],
            ['key' => 'password_expiry_days', 'value' => '90', 'description' => 'Masa Berlaku Password (Hari)'],
            ['key' => 'backup_frequency', 'value' => 'daily', 'description' => 'Frekuensi Backup Database'],
        ];

        foreach ($settings as $setting) {
            SystemSetting::create($setting);
        }

        // ==========================================
        // 1. DATA MASTER (AREA, PAKET, ASET JARINGAN)
        // ==========================================
        $areaMakassar = MasterArea::create([
            'code' => 'MKS-01',
            'name' => 'Makassar Pusat',
        ]);

        $paketBasic = Package::create([
            'name' => 'Home Basic 20 Mbps',
            'speed_mbps' => 20,
            'price' => 150000,
            'installation_fee' => 100000,
            'description' => 'Paket hemat cocok untuk 3-5 perangkat. Kecepatan unduh hingga 20 Mbps tanpa FUP.',
            'is_active' => true,
        ]);

        $paketPro = Package::create([
            'name' => 'Home Pro 50 Mbps',
            'speed_mbps' => 50,
            'price' => 250000,
            'installation_fee' => 100000,
            'description' => 'Paket cepat untuk keluarga besar. Streaming 4K lancar dan bermain game tanpa lag.',
            'is_active' => true,
        ]);

        $routerUtama = NetworkAsset::create([
            'name' => 'Router Utama (Core MKS)',
            'type' => 'Router',
            'ip_address' => '192.168.88.1',
            'location' => 'Data Center Gedung A',
            'is_active' => true,
        ]);

        // ==========================================
        // 2. DATA PENGGUNA (PEGAWAI)
        // ==========================================
        $superAdmin = User::create([
            'name' => 'justrifkyy (Super Admin)',
            'email' => 'owner@netmanager.local',
            'password' => Hash::make('password'),
            'role' => 'super_admin',
            'area_id' => $areaMakassar->id,
            'phone_number' => '08111222333',
            'email_verified_at' => now(),
            'is_active' => true,
        ]);

        $admin = User::create([
            'name' => 'Admin Operasional',
            'email' => 'admin@netmanager.local',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'area_id' => $areaMakassar->id,
            'phone_number' => '08222333444',
            'email_verified_at' => now(),
            'is_active' => true,
        ]);

        $marketing = User::create([
            'name' => 'Staf Marketing',
            'email' => 'marketing@netmanager.local',
            'password' => Hash::make('password'),
            'role' => 'marketing',
            'area_id' => $areaMakassar->id,
            'phone_number' => '08333444555',
            'marketing_code' => 'PROMO2026',
            'email_verified_at' => now(),
            'is_active' => true,
        ]);

        $teknisi = User::create([
            'name' => 'Teknisi Lapangan',
            'email' => 'teknisi@netmanager.local',
            'password' => Hash::make('password'),
            'role' => 'technician',
            'area_id' => $areaMakassar->id,
            'phone_number' => '08444555666',
            'email_verified_at' => now(),
            'is_active' => true,
        ]);

        // ==========================================
        // 3. WORKFLOW: PELANGGAN AKTIF (SUDAH INSTALASI)
        // ==========================================
        
        // A. Data Lead (Prospek Awal)
        $leadAktif = Lead::create([
            'marketing_id' => $marketing->id,
            'package_id' => $paketPro->id,
            'name' => 'Budi Santoso',
            'email' => 'budisantoso@example.com',
            'phone' => '081234567890',
            'customer_type' => 'personal',
            'address' => 'Jl. Perintis Kemerdekaan No. 10',
            'address_installation' => 'Jl. Perintis Kemerdekaan No. 10',
            'district' => 'Tamalanrea',
            'city' => 'Makassar',
            'status' => 'aktif',
            'registered_date' => now()->subMonths(2),
            'created_at' => now()->subMonths(2),
        ]);

        // B. Akun & Profil Customer
        $userCustomer = User::create([
            'name' => 'Budi Santoso',
            'email' => 'budi@netmanager.local',
            'password' => Hash::make('password'),
            'role' => 'customer',
            'phone_number' => '081234567890',
            'email_verified_at' => now(),
            'is_active' => true,
        ]);

        $customer = Customer::create([
            'user_id' => $userCustomer->id,
            'lead_id' => $leadAktif->id,
            'customer_code' => 'CUST-001',
            'phone_number' => '081234567890',
            'address_installation' => 'Jl. Perintis Kemerdekaan No. 10',
        ]);

        // C. Data Instalasi & Jaringan (Tersimpan di Tabel Tiket)
        Ticket::create([
            'customer_id' => $customer->id,
            'technician_id' => $teknisi->id,
            'type' => 'installation',
            'status' => 'closed',
            'subject' => 'Instalasi Jaringan - Budi Santoso',
            'installation_date' => now()->subMonths(2)->addDays(3),
            'connection_type' => 'fiber',
            'cable_length' => '45 Meter',
            'device_type' => 'ONU ZTE',
            'device_brand' => 'ZTE F609',
            'device_mac' => '00:1A:2B:3C:4D:5E',
            'router_id' => $routerUtama->id,
            'vlan_id' => '100',
            'odp_port' => 'Port 3',
            'completed_at' => now()->subMonths(2)->addDays(3),
            'created_at' => now()->subMonths(2)->addDays(2),
        ]);

        // D. Data Langganan & Tagihan
        $subscription = Subscription::create([
            'customer_id' => $customer->id,
            'package_id' => $paketPro->id,
            'pppoe_username' => 'budi@net',
            'pppoe_password' => '123456',
            'ip_address' => '10.10.10.2',
            'installation_date' => now()->subMonths(2)->addDays(3),
            'status' => 'active',
        ]);

        Invoice::create([
            'subscription_id' => $subscription->id,
            'invoice_number' => 'INV-' . now()->format('Ymd') . '-001',
            'amount' => $paketPro->price,
            'status' => 'unpaid',
            'due_date' => now()->addDays(5),
            'payment_method' => null,
        ]);

        // ==========================================
        // 4. WORKFLOW: TIKET GANGGUAN (REPAIR) BARU
        // ==========================================
        Ticket::create([
            'customer_id' => $customer->id,
            'technician_id' => null, // Belum diambil (Open)
            'type' => 'repair',
            'status' => 'open',
            'subject' => 'Gangguan LOS Merah - CUST-001',
            'description' => 'Lampu indikator modem LOS berkedip merah. Internet terputus total sejak kemarin sore.',
            'created_at' => now(),
        ]);

        // ==========================================
        // 5. WORKFLOW: LEAD BARU (PROSPEK)
        // ==========================================
        Lead::create([
            'marketing_id' => $marketing->id,
            'package_id' => $paketBasic->id,
            'name' => 'Siti Aminah',
            'phone' => '089876543210',
            'customer_type' => 'personal',
            'address' => 'Jl. Urip Sumoharjo No. 45',
            'district' => 'Panakkukang',
            'city' => 'Makassar',
            'status' => 'prospek',
            'source' => 'Website Register',
            'registered_date' => now(),
            'created_at' => now(),
        ]);
    }
}