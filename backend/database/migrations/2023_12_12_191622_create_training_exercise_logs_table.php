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
            $table->foreignId('training_exercise_list_log_id')->constrained('training_exercise_list_logs')->onDelete('cascade');
            $table->integer('weight');
            $table->integer('reps');
            $table->dateTime('started_at');
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
