<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('survey_forms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lead_id')->constrained('leads')->onDelete('cascade');
            $table->foreignId('technician_id')->nullable()->constrained('users')->onDelete('set null');
            
            // Status Survey
            $table->enum('survey_status', ['layak', 'tidak_layak'])->nullable();
            $table->date('survey_date')->nullable();
            $table->text('survey_result')->nullable();
            $table->text('location_challenge')->nullable();
            $table->string('location_photo_path')->nullable();
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('survey_forms');
    }
};
