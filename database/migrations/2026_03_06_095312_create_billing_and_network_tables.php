<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Tabel Network Assets (Data Router/OLT)
        if (!Schema::hasTable('network_assets')) {
            Schema::create('network_assets', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('location')->nullable();
                $table->string('ip_address')->nullable();
                $table->string('brand')->nullable();
                $table->string('type')->nullable(); // OLT, Router, AP, ODP
                $table->boolean('is_active')->default(true);
                $table->timestamps();
            });
        }

        // 2. Tabel Subscriptions (Data Langganan Pelanggan)
        if (!Schema::hasTable('subscriptions')) {
            Schema::create('subscriptions', function (Blueprint $table) {
                $table->id();
                $table->foreignId('customer_id')->constrained('customers')->cascadeOnDelete();
                $table->foreignId('package_id')->constrained('packages')->cascadeOnDelete();
                $table->string('pppoe_username')->nullable();
                $table->string('pppoe_password')->nullable();
                $table->string('ip_address')->nullable();
                $table->date('installation_date')->nullable();
                $table->integer('billing_due_date')->nullable(); // Tanggal jatuh tempo (misal: tgl 5)
                $table->string('status')->default('active'); // active, isolated
                $table->timestamps();
            });
        }

        // 3. Tabel Invoices (Data Tagihan / Keuangan)
        if (!Schema::hasTable('invoices')) {
            Schema::create('invoices', function (Blueprint $table) {
                $table->id();
                $table->foreignId('subscription_id')->constrained('subscriptions')->cascadeOnDelete();
                $table->string('invoice_number')->unique();
                $table->decimal('amount', 12, 2);
                $table->string('status')->default('unpaid'); // unpaid, paid
                $table->date('due_date');
                $table->datetime('paid_at')->nullable();
                $table->string('payment_method')->nullable();
                $table->string('snap_token')->nullable(); // Token untuk integrasi Midtrans
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('invoices');
        Schema::dropIfExists('subscriptions');
        Schema::dropIfExists('network_assets');
    }
};