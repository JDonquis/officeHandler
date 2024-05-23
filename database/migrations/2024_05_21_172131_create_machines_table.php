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
        Schema::create('machines', function (Blueprint $table) {
            
            $table->id();
            $table->string('code');
            $table->string('name');
            $table->string('brand');
            $table->string('model');
            $table->string('manufacturer');
            $table->string('serial_number');
            $table->foreignId('location_id');
            $table->foreignId('office_id');
            $table->foreignId('division_id');
            $table->foreignId('department_id');
            $table->string('photo')->nullable();
            $table->text('observation')->nullable();
            $table->string('search')->nullable();
            $table->timestamps();
        
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('machines');
    }
};
