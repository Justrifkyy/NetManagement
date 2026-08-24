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
        // 1. Tabel system_settings
        Schema::create('system_settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->text('value')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
        });

        // 2. Tabel audit_logs
        Schema::create('audit_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('action');
            $table->text('description')->nullable();
            $table->json('details')->nullable(); // Cast array di model
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->timestamps();
        });

        // 3. Tabel system_integrations
        Schema::create('system_integrations', function (Blueprint $table) {
            $table->id();
            $table->string('service_name');
            $table->text('api_key');
            $table->text('api_secret')->nullable();
            $table->string('webhook_url')->nullable();
            $table->boolean('is_active')->default(false);
            $table->timestamps();
        });

        // 4. Tabel role_permissions
        Schema::create('role_permissions', function (Blueprint $table) {
            $table->id();
            $table->string('role');
            $table->string('permission');
            $table->text('description')->nullable();
            // Catatan: Tidak menggunakan timestamps() karena di Model di-set false
        });

        // 5. Tabel notifications (Custom milik Anda, bukan notifikasi bawaan Laravel)
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->cascadeOnDelete();
            $table->string('type');
            
            // Kolom Morph Polimorfik (notifiable_type & notifiable_id)
            $table->string('notifiable_type');
            $table->unsignedBigInteger('notifiable_id');
            
            $table->string('recipient_email');
            $table->string('subject');
            $table->text('body');
            $table->string('channel');
            $table->timestamp('sent_at')->nullable();
            $table->timestamp('read_at')->nullable();
            $table->json('data')->nullable(); // Cast array di model
            $table->timestamps();
            
            // Indexing agar pencarian notifikasi lebih cepat
            $table->index(['notifiable_type', 'notifiable_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
        Schema::dropIfExists('role_permissions');
        Schema::dropIfExists('system_integrations');
        Schema::dropIfExists('audit_logs');
        Schema::dropIfExists('system_settings');
    }
};