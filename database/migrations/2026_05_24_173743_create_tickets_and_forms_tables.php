<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. SURVEY FORMS (Formulir Khusus Survey)
        Schema::create('survey_forms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lead_id')->constrained('leads')->cascadeOnDelete();
            $table->date('survey_date')->nullable();
            $table->enum('survey_status', ['layak', 'tidak_layak'])->nullable();
            $table->text('survey_notes')->nullable();
            $table->string('location_photo_path')->nullable();
            $table->timestamps();
        });

        // 2. INSTALLATION FORMS (Formulir Khusus Pemasangan Baru)
        Schema::create('installation_forms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lead_id')->constrained('leads')->cascadeOnDelete();
            $table->date('installation_date')->nullable();
            $table->enum('connection_type', ['fiber', 'wireless'])->nullable();
            $table->integer('cable_length')->nullable(); // dalam meter
            $table->enum('status', ['berhasil', 'gagal'])->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        // 3. DEVICE CONFIGS (Detail Perangkat - 1 to 1 dengan Instalasi)
        Schema::create('device_configs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('installation_id')->unique()->constrained('installation_forms')->cascadeOnDelete();
            $table->string('device_type')->nullable(); // Router, Modem, ONU
            $table->string('device_brand')->nullable();
            $table->string('mac_address')->nullable();
            $table->string('serial_number')->nullable();
            $table->timestamps();
        });

        // 4. NETWORK CONFIGS (Detail Jaringan - 1 to 1 dengan Instalasi)
        Schema::create('network_configs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('installation_id')->unique()->constrained('installation_forms')->cascadeOnDelete();
            $table->foreignId('router_id')->nullable()->constrained('network_assets')->nullOnDelete();
            $table->string('vlan_id')->nullable();
            $table->string('odp_port')->nullable();
            $table->timestamps();
        });

        // 5. REPAIR FORMS (Formulir Baru: Khusus Pelanggan Lama yang Komplain)
        Schema::create('repair_forms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained('customers')->cascadeOnDelete();
            $table->date('repair_date')->nullable();
            $table->text('issue_description')->nullable();
            $table->text('resolution_notes')->nullable();
            $table->boolean('is_resolved')->default(false);
            $table->timestamps();
        });

        // 6. TICKETS (Task Manager - Polymorphic)
        // Dibuat paling terakhir agar bisa mengikat formulir di atas
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            
            // Relasi Polymorphic (Akan otomatis membuat kolom `ticketable_type` dan `ticketable_id`)
            // Contoh isi: ticketable_type = 'App\Models\SurveyForm', ticketable_id = 1
            $table->nullableMorphs('ticketable'); 
            
            // Relasi Opsional (Hanya diisi jika ini tiket perbaikan pelanggan lama)
            $table->foreignId('customer_id')->nullable()->constrained('customers')->cascadeOnDelete();
            
            // Siapa teknisi yang mengambil tugas ini dari Bursa Tugas (Open Tickets)
            $table->foreignId('technician_id')->nullable()->constrained('users')->nullOnDelete();
            
            $table->enum('type', ['survey', 'installation', 'repair']);
            $table->enum('status', ['open', 'assigned', 'in_progress', 'resolved', 'closed'])->default('open');
            $table->string('subject');
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        // Urutan drop dari bawah ke atas
        Schema::dropIfExists('tickets');
        Schema::dropIfExists('repair_forms');
        Schema::dropIfExists('network_configs');
        Schema::dropIfExists('device_configs');
        Schema::dropIfExists('installation_forms');
        Schema::dropIfExists('survey_forms');
    }
};