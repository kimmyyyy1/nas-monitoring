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
        Schema::create('program_reports', function (Blueprint $table) {
            $table->id();
            $table->string('proponent')->nullable();
            $table->string('program_title'); // Required
            $table->string('target_beneficiaries')->nullable();
            $table->string('output_indicator')->nullable();
            $table->text('accomplishment')->nullable(); 
            $table->date('date_of_implementation'); // Required
            $table->date('date_of_completion')->nullable(); 
            $table->string('movs')->nullable(); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('program_reports');
    }
};
