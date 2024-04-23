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
        Schema::create('wards', function (Blueprint $table) {
            $table->id();
            $table->string('cityId')->nullable();
            $table->string('wardId')->nullable();
            $table->string('wardName')->nullable();
            $table->string('wardCode')->nullable();
            $table->string('primaryHealthCares')->nullable();
            $table->string('secondaryHealthCares')->nullable();
            $table->string('teachingHospitals')->nullable();
            $table->string('hospitals')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wards');
    }
};
