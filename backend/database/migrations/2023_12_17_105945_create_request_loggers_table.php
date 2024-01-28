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
        Schema::create('request_logs', function (Blueprint $table) {
            $table->id();
            $table->string('path');
            $table->string('action');
            $table->string('method');
            $table->json('request_body')->nullable();
            $table->integer('status_code');
            $table->string('ip_address');
            $table->string('user_agent')->nullable();
            $table->foreignId('user_id')->nullable();
            $table->double('duration', 8, 5);
            $table->integer('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('request_logs');
    }
};
