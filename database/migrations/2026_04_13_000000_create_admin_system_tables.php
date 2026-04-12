<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Audit Logs Table
        if (!Schema::hasTable('audit_logs')) {
            Schema::create('audit_logs', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
                $table->string('action');
                $table->text('description')->nullable();
                $table->json('details')->nullable();
                $table->string('ip_address')->nullable();
                $table->text('user_agent')->nullable();
                $table->timestamps();
                
                $table->index('action');
                $table->index('created_at');
            });
        }

        // 2. System Settings Table
        if (!Schema::hasTable('system_settings')) {
            Schema::create('system_settings', function (Blueprint $table) {
                $table->id();
                $table->string('key')->unique();
                $table->text('value')->nullable();
                $table->text('description')->nullable();
                $table->timestamps();
            });
        }

        // 3. Role Permissions Table
        if (!Schema::hasTable('role_permissions')) {
            Schema::create('role_permissions', function (Blueprint $table) {
                $table->id();
                $table->string('role');
                $table->string('permission');
                $table->text('description')->nullable();
                
                $table->unique(['role', 'permission']);
            });
        }

        // 4. Master Areas Table
        if (!Schema::hasTable('master_areas')) {
            Schema::create('master_areas', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('code')->unique();
                $table->text('description')->nullable();
                $table->timestamps();
            });
        }

        // 5. Master Technicians Table
        if (!Schema::hasTable('master_technicians')) {
            Schema::create('master_technicians', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('phone');
                $table->foreignId('area_id')->constrained('master_areas')->cascadeOnDelete();
                $table->timestamps();
            });
        }

        // 6. Master Marketing Table
        if (!Schema::hasTable('master_marketings')) {
            Schema::create('master_marketings', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('code')->unique();
                $table->string('phone');
                $table->timestamps();
            });
        }

        // 7. System Integrations Table
        if (!Schema::hasTable('system_integrations')) {
            Schema::create('system_integrations', function (Blueprint $table) {
                $table->id();
                $table->string('service_name');
                $table->text('api_key');
                $table->text('api_secret')->nullable();
                $table->string('webhook_url')->nullable();
                $table->boolean('is_active')->default(false);
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('system_integrations');
        Schema::dropIfExists('master_marketings');
        Schema::dropIfExists('master_technicians');
        Schema::dropIfExists('master_areas');
        Schema::dropIfExists('role_permissions');
        Schema::dropIfExists('system_settings');
        Schema::dropIfExists('audit_logs');
    }
};
