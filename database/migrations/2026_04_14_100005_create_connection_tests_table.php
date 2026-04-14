<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('connection_tests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('installation_id')->nullable()->constrained('installation_forms')->onDelete('cascade');
            $table->foreignId('lead_id')->constrained('leads')->onDelete('cascade');
            
            // Uji Koneksi
            $table->enum('connection_status', ['berhasil', 'gagal'])->nullable();
            $table->decimal('speed_test_download', 10, 2)->nullable(); // Mbps
            $table->decimal('speed_test_upload', 10, 2)->nullable(); // Mbps
            $table->integer('latency')->nullable(); // ms
            $table->string('test_result_photo_path')->nullable();
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('connection_tests');
    }
};
