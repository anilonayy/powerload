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
        Schema::create('training_exercise_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('training_log_id');
            $table->foreignId('exercise_id');
            $table->integer('weight');
            $table->integer('reps');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('training_exercise_logs');
    }
};
