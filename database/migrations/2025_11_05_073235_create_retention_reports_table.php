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
        Schema::create('retention_reports', function (Blueprint $table) {
            $table->id();
            $table->string('quarter'); // e.g., "1st Quarter"
            $table->string('grade_level'); // e.g., "Grade 7"
            $table->string('focus_sports'); // e.g., "AQUATICS", "ATHLETICS"

            // Data from SY 23-24 Enrollment
            $table->integer('initial_enrollment_male')->default(0);
            $table->integer('initial_enrollment_female')->default(0);

            // Data for TRANSFER
            $table->integer('transfer_male')->default(0);
            $table->integer('transfer_female')->default(0);

            // Data for DROPPED
            $table->integer('dropped_male')->default(0);
            $table->integer('dropped_female')->default(0);

            // Data for PROJECTED ENROLLEES FOR NEXT SY
            $table->integer('projected_enrollees_male')->default(0);
            $table->integer('projected_enrollees_female')->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('retention_reports');
    }
};
