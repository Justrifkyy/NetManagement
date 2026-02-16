<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tickets', function (Blueprint $table) {
            // 1. DATA SURVEY
            $table->string('survey_status')->nullable(); // Layak / Tidak
            $table->date('survey_date')->nullable();
            $table->text('survey_notes')->nullable(); // Hasil singkat
            $table->text('location_obstacle')->nullable(); // Kendala
            $table->string('location_photo_path')->nullable(); // Foto Lokasi

            // 2. DATA INSTALASI
            $table->date('installation_date')->nullable();
            // connection_type sudah ada
            // cable_length sudah ada
            $table->string('mounting_position')->nullable(); // Posisi pasang
            $table->string('installation_status')->nullable(); // Berhasil/Gagal
            $table->text('installation_notes')->nullable();

            // 3. DATA PERANGKAT (Update yang belum ada)
            $table->string('device_type')->nullable(); // Jenis Perangkat
            // brand, sn, mac, condition sudah ada

            // 4. DATA JARINGAN
            // router_id sudah ada
            $table->string('port_interface')->nullable(); // Port/Interface
            // vlan_id, odp_port, dbm_signal sudah ada
            $table->string('olt_source')->nullable(); // OLT/AP Sumber
            $table->string('connection_mode')->default('PPPoE'); // Mode Koneksi

            // 5. DATA AKUN INTERNET
            $table->string('pppoe_username')->nullable();
            $table->string('pppoe_password')->nullable();
            // paket layanan ambil dari relasi customer->lead->package
            $table->string('service_status')->default('Inactive'); // Status Layanan

            // 6. DATA UJI KONEKSI
            $table->string('connectivity_status')->nullable();
            // speed_test, latency, speedtest_photo sudah ada

            // 7. SERAH TERIMA
            $table->boolean('internet_active_confirmation')->default(false);
            $table->date('handover_date')->nullable();
            $table->text('final_technician_notes')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('tickets', function (Blueprint $table) {
            // Hapus kolom jika rollback (opsional)
        });
    }
};