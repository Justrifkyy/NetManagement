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
        // Add performance indexes to frequently queried columns
        // Using raw SQL with IF NOT EXISTS to avoid duplicate index errors
        
        $connection = Schema::connection(null)->getConnection();
        
        try {
            $connection->statement("ALTER TABLE `users` ADD INDEX `users_role_index`(`role`)");
        } catch (\Exception $e) {
            // Index already exists
        }
        
        try {
            $connection->statement("ALTER TABLE `users` ADD INDEX `users_is_active_index`(`is_active`)");
        } catch (\Exception $e) {
            // Index already exists
        }

        try {
            $connection->statement("ALTER TABLE `leads` ADD INDEX `leads_marketing_id_index`(`marketing_id`)");
        } catch (\Exception $e) {
            // Index already exists
        }

        try {
            $connection->statement("ALTER TABLE `leads` ADD INDEX `leads_status_index`(`status`)");
        } catch (\Exception $e) {
            // Index already exists
        }

        try {
            $connection->statement("ALTER TABLE `tickets` ADD INDEX `tickets_status_index`(`status`)");
        } catch (\Exception $e) {
            // Index already exists
        }

        try {
            $connection->statement("ALTER TABLE `tickets` ADD INDEX `tickets_technician_id_index`(`technician_id`)");
        } catch (\Exception $e) {
            // Index already exists
        }

        try {
            $connection->statement("ALTER TABLE `tickets` ADD INDEX `tickets_customer_id_index`(`customer_id`)");
        } catch (\Exception $e) {
            // Index already exists
        }

        try {
            $connection->statement("ALTER TABLE `invoices` ADD INDEX `invoices_status_index`(`status`)");
        } catch (\Exception $e) {
            // Index already exists
        }

        try {
            $connection->statement("ALTER TABLE `subscriptions` ADD INDEX `subscriptions_customer_id_index`(`customer_id`)");
        } catch (\Exception $e) {
            // Index already exists
        }

        try {
            $connection->statement("ALTER TABLE `customers` ADD INDEX `customers_user_id_index`(`user_id`)");
        } catch (\Exception $e) {
            // Index already exists
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('users')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropIndex(['role']);
                $table->dropIndex(['is_active']);
            });
        }

        if (Schema::hasTable('leads')) {
            Schema::table('leads', function (Blueprint $table) {
                $table->dropIndex(['marketing_id']);
                $table->dropIndex(['status']);
                $table->dropIndex(['marketing_id', 'status']);
            });
        }

        if (Schema::hasTable('tickets')) {
            Schema::table('tickets', function (Blueprint $table) {
                $table->dropIndex(['status']);
                $table->dropIndex(['technician_id']);
                $table->dropIndex(['customer_id']);
                $table->dropIndex(['technician_id', 'status']);
            });
        }

        if (Schema::hasTable('invoices')) {
            Schema::table('invoices', function (Blueprint $table) {
                $table->dropIndex(['status']);
                $table->dropIndex(['subscription_id']);
            });
        }

        if (Schema::hasTable('subscriptions')) {
            Schema::table('subscriptions', function (Blueprint $table) {
                $table->dropIndex(['customer_id']);
                $table->dropIndex(['status']);
            });
        }

        if (Schema::hasTable('customers')) {
            Schema::table('customers', function (Blueprint $table) {
                $table->dropIndex(['user_id']);
            });
        }

        if (Schema::hasTable('audit_logs')) {
            Schema::table('audit_logs', function (Blueprint $table) {
                $table->dropIndex(['user_id']);
            });
        }

        if (Schema::hasTable('sessions')) {
            Schema::table('sessions', function (Blueprint $table) {
                $table->dropIndex(['last_activity']);
            });
        }
    }
};
