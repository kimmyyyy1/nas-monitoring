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
        Schema::create('facility_reports', function (Blueprint $table) {
            $table->id();
            $table->string('type_of_facility'); // Required
            $table->date('date_project_completed')->nullable();
            $table->date('date_certified'); // Required
            $table->string('certifying_body')->nullable();
            $table->string('movs')->nullable(); // Means of Verification
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('facility_reports');
    }
};
