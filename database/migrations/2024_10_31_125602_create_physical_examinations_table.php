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
        Schema::create('physical_examinations', function (Blueprint $table) {
            $table->id();
            $table->string('height');
            $table->string('weight');
            $table->string('heart');
            $table->string('lungs');
            $table->string('eyes');
            $table->string('ears');
            $table->string('nose');
            $table->string('throat');
            $table->string('skin');
            $table->string('bp');
            $table->string('remarks');
            // Foreign ID to User
            $table->foreignId('user_id')->constrained();
            // Foreign ID to Doctor
            $table->foreignId('doctor_id')->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('physical_examinations');
    }
};
