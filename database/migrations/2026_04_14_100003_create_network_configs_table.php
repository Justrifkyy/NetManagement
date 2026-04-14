<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('network_configs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('installation_id')->nullable()->constrained('installation_forms')->onDelete('cascade');
            $table->foreignId('lead_id')->constrained('leads')->onDelete('cascade');
            
            // Konfigurasi Jaringan
            $table->string('router_area')->nullable();
            $table->string('port_interface')->nullable();
            $table->string('vlan_id')->nullable();
            $table->string('olt_access_point')->nullable();
            $table->enum('connection_mode', ['pppoe', 'static_ip', 'dhcp'])->default('pppoe');
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('network_configs');
    }
};
