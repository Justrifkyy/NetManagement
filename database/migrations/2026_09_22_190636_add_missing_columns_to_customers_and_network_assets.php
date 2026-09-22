<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Fix Error 1054: Unknown column 'coordinates' in customers table.
     * Fix Error 1054: Unknown column 'brand' in network_assets table.
     * Fix Error 1146: Create personal_access_tokens for Laravel Sanctum.
     */
    public function up(): void
    {
        // Fix 1: Tambah kolom 'coordinates' ke tabel customers (jika belum ada)
        if (Schema::hasTable('customers') && !Schema::hasColumn('customers', 'coordinates')) {
            Schema::table('customers', function (Blueprint $table) {
                $table->string('coordinates')->nullable()->after('address_installation');
            });
        }

        // Fix 2: Tambah kolom 'brand' ke tabel network_assets (jika belum ada)
        if (Schema::hasTable('network_assets') && !Schema::hasColumn('network_assets', 'brand')) {
            Schema::table('network_assets', function (Blueprint $table) {
                $table->string('brand')->nullable()->after('type');
            });
        }

        // Fix 3: Buat tabel personal_access_tokens untuk Laravel Sanctum (jika belum ada)
        if (!Schema::hasTable('personal_access_tokens')) {
            Schema::create('personal_access_tokens', function (Blueprint $table) {
                $table->id();
                $table->morphs('tokenable');
                $table->string('name');
                $table->string('token', 64)->unique();
                $table->text('abilities')->nullable();
                $table->timestamp('last_used_at')->nullable();
                $table->timestamp('expires_at')->nullable();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('customers') && Schema::hasColumn('customers', 'coordinates')) {
            Schema::table('customers', function (Blueprint $table) {
                $table->dropColumn('coordinates');
            });
        }

        if (Schema::hasTable('network_assets') && Schema::hasColumn('network_assets', 'brand')) {
            Schema::table('network_assets', function (Blueprint $table) {
                $table->dropColumn('brand');
            });
        }

        Schema::dropIfExists('personal_access_tokens');
    }
};
