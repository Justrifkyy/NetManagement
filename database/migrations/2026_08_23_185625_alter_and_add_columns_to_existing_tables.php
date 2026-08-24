<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. UPDATE TABEL LEADS (Menambahkan form input Marketing)
        Schema::table('leads', function (Blueprint $table) {
            $table->string('email')->nullable()->after('phone');
            $table->string('phone_backup')->nullable()->after('email');
            $table->string('customer_type')->nullable()->after('phone_backup');
            $table->string('business_name')->nullable()->after('customer_type');
            $table->string('mother_name')->nullable()->after('business_name');
            
            $table->string('emergency_name')->nullable();
            $table->string('emergency_phone')->nullable();
            $table->string('emergency_relation')->nullable();
            
            $table->text('address_ktp')->nullable();
            $table->text('address_installation')->nullable();
            $table->string('rt_rw')->nullable();
            $table->string('village')->nullable();
            $table->string('district')->nullable();
            $table->string('city')->nullable();
            $table->string('province')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('landmark')->nullable();
            
            $table->string('promo_code')->nullable();
            $table->decimal('installation_fee', 12, 2)->nullable();
            $table->string('source')->nullable();
            
            $table->date('registered_date')->nullable();
            $table->date('survey_date')->nullable();
            $table->date('installation_date')->nullable();
            $table->string('preferred_time')->nullable();
            
            $table->text('notes_summary')->nullable();
            $table->text('notes_obstacle')->nullable();
            $table->text('notes_special')->nullable();
            
            $table->string('ktp_image_path')->nullable();
            $table->string('house_image_path')->nullable();
            $table->string('customer_image_path')->nullable();
        });

        // 2. UPDATE TABEL PACKAGES
        Schema::table('packages', function (Blueprint $table) {
            $table->text('description')->nullable()->after('installation_fee');
        });

        // 3. UPDATE TABEL INVOICES
        Schema::table('invoices', function (Blueprint $table) {
            $table->string('payment_method')->nullable()->after('status');
        });

        // 4. UPDATE TABEL SUBSCRIPTIONS
        Schema::table('subscriptions', function (Blueprint $table) {
            $table->date('installation_date')->nullable()->after('ip_address');
            $table->date('billing_due_date')->nullable()->after('installation_date');
        });

        // 5. UPDATE TABEL TICKETS (Merombak total agar teknisi bisa input langsung)
        Schema::table('tickets', function (Blueprint $table) {
            // Umum
            $table->text('description')->nullable();
            $table->text('technical_notes')->nullable();
            $table->text('notes')->nullable();
            $table->date('completion_date')->nullable();

            // Form Survey
            $table->string('survey_status')->nullable();
            $table->date('survey_date')->nullable();
            $table->text('survey_notes')->nullable();
            $table->string('location_obstacle')->nullable();
            $table->string('location_photo_path')->nullable();

            // Form Instalasi
            $table->date('installation_date')->nullable();
            $table->string('connection_type')->nullable();
            $table->string('cable_length')->nullable();
            $table->string('mounting_position')->nullable();
            $table->string('installation_status')->nullable();
            $table->text('installation_notes')->nullable();

            // Form Perangkat
            $table->string('device_type')->nullable();
            $table->string('device_brand')->nullable();
            $table->string('device_sn')->nullable();
            $table->string('device_mac')->nullable();
            $table->string('device_condition')->nullable();

            // Form Jaringan
            $table->unsignedBigInteger('router_id')->nullable();
            $table->string('port_interface')->nullable();
            $table->string('vlan_id')->nullable();
            $table->string('odp_port')->nullable();
            $table->string('olt_source')->nullable();
            $table->string('connection_mode')->nullable();
            $table->string('dbm_signal')->nullable();

            // Akun PPPoE
            $table->string('pppoe_username')->nullable();
            $table->string('pppoe_password')->nullable();
            $table->string('service_status')->nullable();

            // Uji Koneksi
            $table->string('connectivity_status')->nullable();
            $table->string('speed_test_result')->nullable();
            $table->string('latency')->nullable();
            $table->string('speedtest_photo_path')->nullable();

            // Serah Terima
            $table->boolean('internet_active_confirmation')->default(false);
            $table->date('handover_date')->nullable();
            $table->text('final_technician_notes')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->string('evidence_photo_path')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert perubahan tabel tickets
        Schema::table('tickets', function (Blueprint $table) {
            $table->dropColumn([
                'description', 'technical_notes', 'notes', 'completion_date',
                'survey_status', 'survey_date', 'survey_notes', 'location_obstacle', 'location_photo_path',
                'installation_date', 'connection_type', 'cable_length', 'mounting_position', 'installation_status', 'installation_notes',
                'device_type', 'device_brand', 'device_sn', 'device_mac', 'device_condition',
                'router_id', 'port_interface', 'vlan_id', 'odp_port', 'olt_source', 'connection_mode', 'dbm_signal',
                'pppoe_username', 'pppoe_password', 'service_status',
                'connectivity_status', 'speed_test_result', 'latency', 'speedtest_photo_path',
                'internet_active_confirmation', 'handover_date', 'final_technician_notes', 'completed_at', 'evidence_photo_path'
            ]);
        });

        // Revert subscriptions
        Schema::table('subscriptions', function (Blueprint $table) {
            $table->dropColumn(['installation_date', 'billing_due_date']);
        });

        // Revert invoices
        Schema::table('invoices', function (Blueprint $table) {
            $table->dropColumn('payment_method');
        });

        // Revert packages
        Schema::table('packages', function (Blueprint $table) {
            $table->dropColumn('description');
        });

        // Revert leads
        Schema::table('leads', function (Blueprint $table) {
            $table->dropColumn([
                'email', 'phone_backup', 'customer_type', 'business_name', 'mother_name',
                'emergency_name', 'emergency_phone', 'emergency_relation',
                'address_ktp', 'address_installation', 'rt_rw', 'village', 'district', 'city', 'province', 'postal_code', 'landmark',
                'promo_code', 'installation_fee', 'source',
                'registered_date', 'survey_date', 'installation_date', 'preferred_time',
                'notes_summary', 'notes_obstacle', 'notes_special',
                'ktp_image_path', 'house_image_path', 'customer_image_path'
            ]);
        });
    }
};