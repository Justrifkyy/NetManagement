<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Sinkronkan IP router default (192.168.88.1 seeder) dengan MIKROTIK_HOST dari .env
     */
    public function up(): void
    {
        $envHost = env('MIKROTIK_HOST', config('services.mikrotik.host'));
        $envPort = (int) env('MIKROTIK_PORT', config('services.mikrotik.port', 8728));

        if (!empty($envHost) && $envHost !== '192.168.88.1') {
            DB::table('network_assets')
                ->where('type', 'Router')
                ->where('ip_address', '192.168.88.1')
                ->update([
                    'ip_address' => $envHost,
                    'api_port'   => $envPort,
                    'updated_at' => now(),
                ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No-op rollback
    }
};
