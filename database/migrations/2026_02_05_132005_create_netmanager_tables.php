<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // 0. Update Tabel Users (Menambah Kolom Marketing Code)
        // Kita gunakan Schema::table karena tabel users biasanya bawaan Laravel
        if (!Schema::hasColumn('users', 'marketing_code')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('marketing_code')->nullable()->unique()->after('email');
            });
        }

        // 1. Tabel Paket Layanan
        Schema::create('packages', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('speed_mbps');
            $table->decimal('price', 12, 2);
            $table->decimal('installation_fee', 12, 2)->default(0);
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // 2. Tabel Router / Network Assets
        Schema::create('network_assets', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('location');
            $table->string('ip_address')->nullable();
            $table->string('brand')->nullable();
            $table->string('type')->nullable(); // OLT, Router, AP, ODP
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // 3. Tabel LEADS (Prospek) - UPDATED
        Schema::create('leads', function (Blueprint $table) {
            $table->id();
            // REVISI: marketing_id jadi NULLABLE karena user bisa daftar sendiri tanpa sales
            $table->foreignId('marketing_id')->nullable()->constrained('users')->onDelete('set null');

            // A. IDENTITAS
            $table->string('name');
            $table->string('phone');
            $table->string('mother_name')->nullable();
            $table->string('email')->nullable();
            $table->enum('customer_type', ['personal', 'business'])->default('personal');
            $table->string('business_name')->nullable();

            // B. KONTAK DARURAT
            $table->string('emergency_name')->nullable();
            $table->string('emergency_phone')->nullable();
            $table->string('emergency_relation')->nullable();

            // C. ALAMAT
            $table->text('address_ktp')->nullable();        // <--- BARU
            $table->text('address_installation');
            $table->string('rt_rw')->nullable();
            $table->string('village')->nullable();
            $table->string('district')->nullable();
            $table->string('city')->nullable();
            $table->string('province')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('landmark')->nullable();
            $table->string('coordinates')->nullable();

            // D. PAKET
            $table->foreignId('package_id')->nullable()->constrained('packages')->onDelete('set null');
            $table->string('promo_code')->nullable();

            // E. STATUS
            $table->enum('status', ['prospek', 'survey', 'instalasi', 'aktif', 'batal', 'converted'])->default('prospek');
            $table->string('source')->nullable(); // Disini nanti isinya "Website Register"

            // F. JADWAL & CATATAN
            $table->date('survey_date')->nullable();
            $table->date('installation_date')->nullable();
            $table->string('preferred_time')->nullable();
            $table->text('notes_summary')->nullable();
            $table->text('notes_obstacle')->nullable();
            $table->text('notes_special')->nullable();

            // G. FOTO
            $table->string('ktp_image_path')->nullable();
            $table->string('house_image_path')->nullable();
            $table->string('customer_image_path')->nullable();

            $table->timestamps();
        });

        // 4. Tabel CUSTOMERS
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('lead_id')->nullable()->constrained()->onDelete('set null');
            $table->string('customer_code')->unique();
            $table->string('nik')->nullable();
            $table->string('phone_number');
            $table->text('address_installation');
            $table->string('coordinates')->nullable();
            $table->string('pppoe_username')->nullable();
            $table->string('pppoe_password')->nullable();
            $table->boolean('is_isolated')->default(false);
            $table->timestamps();
        });

        // 5. Tabel TICKETS
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained('customers')->onDelete('cascade');
            $table->foreignId('technician_id')->nullable()->constrained('users');
            $table->enum('type', ['survey', 'installation', 'repair']);
            $table->string('subject')->nullable();
            $table->enum('status', ['open', 'assigned', 'in_progress', 'pending', 'resolved', 'closed'])->default('open');
            $table->text('technical_notes')->nullable();
            $table->string('survey_result')->nullable();
            $table->string('connection_type')->nullable();
            $table->integer('cable_length')->nullable();
            $table->string('device_brand')->nullable();
            $table->string('device_sn')->nullable();
            $table->string('device_mac')->nullable();
            $table->string('device_condition')->nullable();
            $table->foreignId('router_id')->nullable()->constrained('network_assets');
            $table->string('odp_port')->nullable();
            $table->string('vlan_id')->nullable();
            $table->string('dbm_signal')->nullable();
            $table->string('speed_test_result')->nullable();
            $table->string('latency')->nullable();
            $table->string('evidence_photo_path')->nullable();
            $table->string('speedtest_photo_path')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tickets');
        Schema::dropIfExists('customers');
        Schema::dropIfExists('leads');
        Schema::dropIfExists('network_assets');
        Schema::dropIfExists('packages');
        if (Schema::hasColumn('users', 'marketing_code')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('marketing_code');
            });
        }
    }
};
  