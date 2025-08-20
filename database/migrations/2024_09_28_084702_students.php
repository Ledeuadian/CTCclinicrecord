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
        //
        Schema::create('students', function (Blueprint $table) {
            $table->bigIncrements('students_id');
            $table->string('first_name');
            $table->string('middle_name');
            $table->string('last_name');
            $table->integer('age');
            $table->string('gender');
            $table->integer('course_id');
            $table->integer('year_id');
            // User Account
            $table->integer('user_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
