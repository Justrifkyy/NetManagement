<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. LEADS (Calon Pelanggan / Prospek)
        Schema::create('leads', function (Blueprint $table) {
            $table->id();
            $table->foreignId('marketing_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('package_id')->constrained('packages');
            $table->string('name');
            $table->string('phone');
            $table->text('address')->nullable();
            $table->string('coordinates')->nullable();
            $table->enum('status', ['prospek', 'survey', 'instalasi', 'aktif', 'batal'])->default('prospek');
            $table->timestamps();
        });

        // 2. CUSTOMERS (Pelanggan Resmi yang sudah deal/aktif)
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            // Setiap customer harus punya akun login (user) dan berasal dari prospek (lead)
            $table->foreignId('user_id')->unique()->constrained('users')->cascadeOnDelete();
            $table->foreignId('lead_id')->unique()->constrained('leads')->cascadeOnDelete();
            
            $table->string('customer_code')->unique();
            $table->string('phone_number');
            $table->text('address_installation');
            $table->boolean('is_isolated')->default(false);
            $table->timestamps();
        });

        // 3. SUBSCRIPTIONS (Data Langganan Internet & Akun PPPoE)
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained('customers')->cascadeOnDelete();
            $table->foreignId('package_id')->constrained('packages');
            
            $table->string('pppoe_username')->unique()->nullable();
            $table->string('pppoe_password')->nullable();
            $table->string('ip_address')->nullable();
            $table->enum('status', ['active', 'isolated', 'suspend'])->default('active');
            $table->timestamps();
        });

        // 4. INVOICES (Tagihan Bulanan)
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('subscription_id')->constrained('subscriptions')->cascadeOnDelete();
            $table->string('invoice_number')->unique();
            $table->decimal('amount', 12, 2);
            $table->enum('status', ['unpaid', 'paid'])->default('unpaid');
            $table->date('due_date');
            $table->timestamp('paid_at')->nullable();
            $table->string('snap_token')->nullable(); // Untuk Midtrans Payment Gateway
            $table->timestamps();
        });
    }

    public function down(): void
    {
        // Urutan drop harus dari bawah ke atas agar foreign key tidak error
        Schema::dropIfExists('invoices');
        Schema::dropIfExists('subscriptions');
        Schema::dropIfExists('customers');
        Schema::dropIfExists('leads');
    }
};