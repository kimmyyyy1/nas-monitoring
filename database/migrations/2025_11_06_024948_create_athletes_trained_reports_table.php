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
        Schema::create('athletes_trained_reports', function (Blueprint $table) {
            $table->id();
            $table->string('quarter'); // e.g., "Q1", "Q2"
            $table->string('grade_level'); // e.g., "Grade 7"
            $table->string('focus_sports'); // e.g., "AQUATICS"

            $table->integer('male_count')->default(0);
            $table->integer('female_count')->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('athletes_trained_reports');
    }
};
