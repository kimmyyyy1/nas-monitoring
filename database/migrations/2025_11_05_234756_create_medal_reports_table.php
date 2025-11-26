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
        Schema::create('medal_reports', function (Blueprint $table) {
            $table->id();
            $table->string('quarter'); // e.g., "1st Quarter"
            $table->string('grade_level'); // e.g., "Grade 7"
            $table->string('focus_sports'); // e.g., "AQUATICS"

            // Data para sa National Competition
            $table->integer('national_gold')->default(0);
            $table->integer('national_silver')->default(0);
            $table->integer('national_bronze')->default(0);

            // Data para sa International Competition
            $table->integer('international_gold')->default(0);
            $table->integer('international_silver')->default(0);
            $table->integer('international_bronze')->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medal_reports');
    }
};
