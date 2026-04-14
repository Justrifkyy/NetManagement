<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('device_configs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('installation_id')->nullable()->constrained('installation_forms')->onDelete('cascade');
            $table->foreignId('lead_id')->constrained('leads')->onDelete('cascade');
            
            // Jenis Perangkat
            $table->string('device_type')->nullable(); // Router, Modem, ONU, dll
            $table->string('device_brand')->nullable();
            $table->string('serial_number')->nullable()->unique();
            $table->string('mac_address')->nullable();
            $table->enum('device_condition', ['baru', 'baik', 'rusak_ringan', 'rusak_berat'])->default('baik');
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('device_configs');
    }
};
