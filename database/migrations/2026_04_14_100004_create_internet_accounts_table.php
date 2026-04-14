<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('internet_accounts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lead_id')->constrained('leads')->onDelete('cascade');
            $table->foreignId('installation_id')->nullable()->constrained('installation_forms')->onDelete('cascade');
            
            // Akun Internet
            $table->string('pppoe_username')->nullable();
            $table->string('pppoe_password')->nullable();
            $table->string('service_package')->nullable();
            $table->enum('initial_service_status', ['aktif', 'tidak_aktif', 'suspend'])->default('aktif');
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('internet_accounts');
    }
};
