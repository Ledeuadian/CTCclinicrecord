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
        Schema::create('certificate_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained('patients')->onDelete('cascade');
            $table->foreignId('certificate_type_id')->constrained('certificate_types')->onDelete('cascade');
            $table->foreignId('doctor_id')->nullable()->constrained('doctors')->onDelete('set null');
            $table->foreignId('appointment_id')->nullable()->constrained('appointments')->onDelete('set null');
            $table->text('reason')->nullable(); // Purpose/reason for the certificate
            $table->enum('status', ['pending', 'approved', 'rejected', 'issued'])->default('pending');
            $table->text('doctor_notes')->nullable();
            $table->timestamp('issued_date')->nullable();
            $table->string('document_path')->nullable(); // Path to uploaded certificate file
            $table->timestamps();
            
            // Indexes for common queries
            $table->index(['patient_id', 'status']);
            $table->index(['doctor_id', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('certificate_requests');
    }
};
