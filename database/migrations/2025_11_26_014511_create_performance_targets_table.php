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
        Schema::create('performance_targets', function (Blueprint $table) {
            $table->id();
            $table->string('indicator_name'); // Pangalan ng indicator (e.g. "Programs")
            $table->integer('q1_target')->default(0);
            $table->integer('q2_target')->default(0);
            $table->integer('q3_target')->default(0);
            $table->integer('q4_target')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('performance_targets');
    }
};
