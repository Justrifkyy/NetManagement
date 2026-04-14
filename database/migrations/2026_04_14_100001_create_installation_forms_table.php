<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('installation_forms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lead_id')->constrained('leads')->onDelete('cascade');
            $table->foreignId('technician_id')->nullable()->constrained('users')->onDelete('set null');
            
            // Tanggal dan Tipe Koneksi
            $table->date('installation_date')->nullable();
            $table->enum('connection_type', ['fiber', 'wireless'])->nullable();
            $table->integer('cable_length')->nullable(); // panjang kabel dalam meter
            $table->text('device_placement')->nullable();
            
            // Status Instalasi
            $table->enum('installation_status', ['berhasil', 'gagal'])->nullable();
            $table->text('installation_notes')->nullable();
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('installation_forms');
    }
};
