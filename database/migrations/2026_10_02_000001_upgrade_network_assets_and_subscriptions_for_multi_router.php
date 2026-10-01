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
        // 1. Modifikasi tabel network_assets
        if (Schema::hasTable('network_assets')) {
            Schema::table('network_assets', function (Blueprint $table) {
                // Buat ip_address nullable untuk mengakomodasi perangkat pasif seperti ODP
                if (Schema::hasColumn('network_assets', 'ip_address')) {
                    $table->string('ip_address')->nullable()->change();
                }

                // Tambahkan kredensial & port API untuk multi-router/OLT
                if (!Schema::hasColumn('network_assets', 'api_username')) {
                    $table->string('api_username')->nullable()->after('ip_address');
                }

                if (!Schema::hasColumn('network_assets', 'api_password')) {
                    $table->text('api_password')->nullable()->after('api_username');
                }

                if (!Schema::hasColumn('network_assets', 'api_port')) {
                    $table->integer('api_port')->nullable()->default(8728)->after('api_password');
                }

                // Tambahkan kapasitas port dan koordinat fisik (khusus ODP / Perangkat Lapangan)
                if (!Schema::hasColumn('network_assets', 'port_capacity')) {
                    $table->integer('port_capacity')->nullable()->after('api_port');
                }

                if (!Schema::hasColumn('network_assets', 'coordinates')) {
                    $table->string('coordinates')->nullable()->after('port_capacity');
                }
            });
        }

        // 2. Modifikasi tabel subscriptions (Relasi permanen ke Router)
        if (Schema::hasTable('subscriptions') && !Schema::hasColumn('subscriptions', 'router_id')) {
            Schema::table('subscriptions', function (Blueprint $table) {
                $table->foreignId('router_id')
                    ->nullable()
                    ->after('package_id')
                    ->constrained('network_assets')
                    ->nullOnDelete();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('subscriptions') && Schema::hasColumn('subscriptions', 'router_id')) {
            Schema::table('subscriptions', function (Blueprint $table) {
                $table->dropConstrainedForeignId('router_id');
            });
        }

        if (Schema::hasTable('network_assets')) {
            Schema::table('network_assets', function (Blueprint $table) {
                $columnsToDrop = [];
                foreach (['api_username', 'api_password', 'api_port', 'port_capacity', 'coordinates'] as $col) {
                    if (Schema::hasColumn('network_assets', $col)) {
                        $columnsToDrop[] = $col;
                    }
                }
                if (!empty($columnsToDrop)) {
                    $table->dropColumn($columnsToDrop);
                }
            });
        }
    }
};
