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
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->foreignId('machine_id');
            $table->foreignId('type_service_id');
            $table->foreignId('user_id');
            $table->date('start');
            $table->string('description')->nullable();
            // 1: En proceso, 2: Completada
            $table->integer('status');
            $table->integer('duration')->nullable();
            $table->date('end')->nullable();
            $table->date('next_service_date')->nullable();
            $table->string('search')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
