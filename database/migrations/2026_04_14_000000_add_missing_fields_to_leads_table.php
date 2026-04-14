<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // Add missing fields to leads table
        Schema::table('leads', function (Blueprint $table) {
            // Add if not exists
            if (!Schema::hasColumn('leads', 'address')) {
                $table->text('address')->nullable()->after('address_installation');
            }
            if (!Schema::hasColumn('leads', 'phone_backup')) {
                $table->string('phone_backup')->nullable()->after('phone');
            }
            if (!Schema::hasColumn('leads', 'installation_fee')) {
                $table->decimal('installation_fee', 12, 2)->default(0)->after('promo_code');
            }
            if (!Schema::hasColumn('leads', 'registered_date')) {
                $table->date('registered_date')->nullable()->after('created_at');
            }
        });
    }

    public function down(): void
    {
        Schema::table('leads', function (Blueprint $table) {
            if (Schema::hasColumn('leads', 'address')) {
                $table->dropColumn('address');
            }
            if (Schema::hasColumn('leads', 'phone_backup')) {
                $table->dropColumn('phone_backup');
            }
            if (Schema::hasColumn('leads', 'installation_fee')) {
                $table->dropColumn('installation_fee');
            }
            if (Schema::hasColumn('leads', 'registered_date')) {
                $table->dropColumn('registered_date');
            }
        });
    }
};
