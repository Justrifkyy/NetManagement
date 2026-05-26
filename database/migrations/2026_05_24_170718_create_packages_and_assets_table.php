<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. PACKAGES
        Schema::create('packages', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('speed_mbps');
            $table->decimal('price', 12, 2);
            $table->decimal('installation_fee', 12, 2)->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // 2. NETWORK ASSETS (Router, OLT, dll)
        Schema::create('network_assets', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum('type', ['Router', 'OLT', 'AP', 'ODP']);
            $table->string('ip_address')->nullable();
            $table->string('location')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('network_assets');
        Schema::dropIfExists('packages');
    }
};