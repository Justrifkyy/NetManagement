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
use App\Models\SurveyForm;
use App\Models\InstallationForm;
use App\Models\DeviceConfig;
use App\Models\NetworkConfig;
use App\Models\RepairForm;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
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
            'is_active' => true,
        ]);

        $paketPro = Package::create([
            'name' => 'Home Pro 50 Mbps',
            'speed_mbps' => 50,
            'price' => 250000,
            'installation_fee' => 100000,
            'is_active' => true,
        ]);

        $routerUtama = NetworkAsset::create([
            'name' => 'Router Utama (Core)',
            'type' => 'Router',
            'ip_address' => '192.168.88.1',
            'location' => 'Data Center MKS',
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
            'email_verified_at' => now(),
        ]);

        $admin = User::create([
            'name' => 'Admin Operasional',
            'email' => 'admin@netmanager.local',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'area_id' => $areaMakassar->id,
            'email_verified_at' => now(),
        ]);

        $marketing = User::create([
            'name' => 'Staf Marketing',
            'email' => 'marketing@netmanager.local',
            'password' => Hash::make('password'),
            'role' => 'marketing',
            'area_id' => $areaMakassar->id,
            'marketing_code' => 'PROMO2026',
            'email_verified_at' => now(),
        ]);

        $teknisi = User::create([
            'name' => 'Teknisi Lapangan',
            'email' => 'teknisi@netmanager.local',
            'password' => Hash::make('password'),
            'role' => 'technician',
            'area_id' => $areaMakassar->id,
            'email_verified_at' => now(),
        ]);

        // ==========================================
        // 3. WORKFLOW: PELANGGAN AKTIF (Sudah lewat Survey & Instalasi)
        // ==========================================
        $leadAktif = Lead::create([
            'marketing_id' => $marketing->id,
            'package_id' => $paketPro->id,
            'name' => 'Budi Santoso',
            'phone' => '081234567890',
            'address' => 'Jl. Perintis Kemerdekaan No. 10',
            'status' => 'aktif',
            'created_at' => now()->subMonths(2),
        ]);

        // A. Form Survey (Selesai)
        $surveyForm = SurveyForm::create([
            'lead_id' => $leadAktif->id,
            'survey_date' => now()->subMonths(2)->addDays(1),
            'survey_status' => 'layak',
            'survey_notes' => 'Tiang ODP tersedia dalam radius 50m.',
        ]);
        
        Ticket::create([
            'ticketable_id' => $surveyForm->id,
            'ticketable_type' => SurveyForm::class,
            'technician_id' => $teknisi->id,
            'type' => 'survey',
            'status' => 'closed',
            'subject' => 'Survey Pemasangan Baru - Budi',
            'created_at' => now()->subMonths(2),
        ]);

        // B. Form Instalasi (Selesai)
        $installForm = InstallationForm::create([
            'lead_id' => $leadAktif->id,
            'installation_date' => now()->subMonths(2)->addDays(3),
            'connection_type' => 'fiber',
            'cable_length' => 45,
            'status' => 'berhasil',
        ]);

        DeviceConfig::create([
            'installation_id' => $installForm->id,
            'device_type' => 'ONU ZTE',
            'mac_address' => '00:1A:2B:3C:4D:5E',
        ]);

        NetworkConfig::create([
            'installation_id' => $installForm->id,
            'router_id' => $routerUtama->id,
            'vlan_id' => '100',
            'odp_port' => 'Port 3',
        ]);

        Ticket::create([
            'ticketable_id' => $installForm->id,
            'ticketable_type' => InstallationForm::class,
            'technician_id' => $teknisi->id,
            'type' => 'installation',
            'status' => 'closed',
            'subject' => 'Instalasi Jaringan - Budi',
            'created_at' => now()->subMonths(2)->addDays(2),
        ]);

        // C. Buat Akun & Profil Customer
        $userCustomer = User::create([
            'name' => 'Budi Santoso',
            'email' => 'budi@netmanager.local',
            'password' => Hash::make('password'),
            'role' => 'customer',
        ]);

        $customer = Customer::create([
            'user_id' => $userCustomer->id,
            'lead_id' => $leadAktif->id,
            'customer_code' => 'CUST-001',
            'phone_number' => '081234567890',
            'address_installation' => 'Jl. Perintis Kemerdekaan No. 10',
        ]);

        $subscription = Subscription::create([
            'customer_id' => $customer->id,
            'package_id' => $paketPro->id,
            'pppoe_username' => 'budi@net',
            'pppoe_password' => '123456',
            'ip_address' => '10.10.10.2',
            'status' => 'active',
        ]);

        Invoice::create([
            'subscription_id' => $subscription->id,
            'invoice_number' => 'INV-' . now()->format('Ymd') . '-001',
            'amount' => $paketPro->price,
            'status' => 'unpaid',
            'due_date' => now()->addDays(5),
        ]);

        // ==========================================
        // 4. WORKFLOW: TIKET GANGGUAN (REPAIR) BARU
        // ==========================================
        // Pelanggan komplain internet mati, masuk ke Bursa Tugas Teknisi
        $repairForm = RepairForm::create([
            'customer_id' => $customer->id,
            'issue_description' => 'Lampu indikator modem LOS berkedip merah. Internet terputus total.',
            'is_resolved' => false,
        ]);

        Ticket::create([
            'ticketable_id' => $repairForm->id,
            'ticketable_type' => RepairForm::class,
            'customer_id' => $customer->id,
            'technician_id' => null, // Belum diambil (Open)
            'type' => 'repair',
            'status' => 'open',
            'subject' => 'Gangguan LOS Merah - CUST-001',
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
            'address' => 'Jl. Urip Sumoharjo No. 45',
            'status' => 'prospek',
        ]);
    }
}