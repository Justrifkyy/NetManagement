<?php

namespace App\Http\Controllers\Integrations;

use App\Http\Controllers\Controller;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class NetworkController extends Controller
{
    /**
     * Konfigurasi Mikrotik (Nanti bisa dipindah ke .env)
     */
    private $routerIp = '192.168.88.1';
    private $routerUser = 'admin';
    private $routerPass = 'password_mikrotik';

    /**
     * Fungsi untuk Mengisolasi Pelanggan (Disable PPPoE / Ganti Profile)
     */
    public function isolateCustomer(Subscription $subscription)
    {
        try {
            // LOGIKA MIKROTIK (Contoh menggunakan cURL atau Library RouterOS API)
            // 1. Konek ke API Mikrotik
            // 2. Cari PPPoE Secret berdasarkan: $subscription->pppoe_username
            // 3. Ubah Profile ke "ISOLIR" atau Disable Secret
            // 4. Putus koneksi aktif (Kick Active Connection) agar langsung terisolir

            Log::info("Mengisolasi PPPoE: " . $subscription->pppoe_username);

            // Update status di database lokal
            $subscription->update(['status' => 'isolated']);

            return back()->with('success', 'Pelanggan berhasil diisolasi di jaringan.');

        } catch (\Exception $e) {
            Log::error("Gagal isolir pelanggan: " . $e->getMessage());
            return back()->with('error', 'Koneksi ke Router gagal!');
        }
    }

    /**
     * Fungsi untuk Menyalakan Kembali Pelanggan (Restore PPPoE)
     */
    public function restoreCustomer(Subscription $subscription)
    {
        try {
            // LOGIKA MIKROTIK
            // 1. Konek ke API Mikrotik
            // 2. Cari PPPoE Secret berdasarkan: $subscription->pppoe_username
            // 3. Ubah Profile kembali ke Paket Normal
            
            Log::info("Menyalakan ulang PPPoE: " . $subscription->pppoe_username);

            // Update status di database lokal
            $subscription->update(['status' => 'active']);

            return back()->with('success', 'Akses internet pelanggan berhasil dipulihkan.');

        } catch (\Exception $e) {
            Log::error("Gagal restore pelanggan: " . $e->getMessage());
            return back()->with('error', 'Koneksi ke Router gagal!');
        }
    }

    /**
     * Cek status koneksi real-time (Uptime, IP saat ini)
     */
    public function checkStatus($username)
    {
        // Hit API Mikrotik -> /ppp/active/print where name=$username
        // Return JSON untuk ditampilkan di dashboard admin/teknisi
        return response()->json([
            'status' => 'online',
            'uptime' => '2d 4h 10m',
            'ip_address' => '10.10.10.25'
        ]);
    }
}