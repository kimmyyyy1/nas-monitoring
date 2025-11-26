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
        Schema::create('learning_standard_reports', function (Blueprint $table) {
            $table->id();

            // Para sa dropdowns
            $table->string('quarter'); // e.g., "1st Quarter"
            $table->string('grade_level'); // e.g., "Grade 7"

            // Data para sa "Outstanding"
            $table->integer('outstanding_male')->default(0);
            $table->integer('outstanding_female')->default(0);

            // Data para sa "Very Satisfactory"
            $table->integer('very_satisfactory_male')->default(0);
            $table->integer('very_satisfactory_female')->default(0);

            // Data para sa "Satisfactory"
            $table->integer('satisfactory_male')->default(0);
            $table->integer('satisfactory_female')->default(0);

            // Data para sa "Fairly Satisfactory"
            $table->integer('fairly_satisfactory_male')->default(0);
            $table->integer('fairly_satisfactory_female')->default(0);

            // Data para sa "Did not Meet"
            $table->integer('did_not_meet_male')->default(0);
            $table->integer('did_not_meet_female')->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('learning_standard_reports');
    }
};
