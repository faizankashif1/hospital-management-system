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
    Schema::create('medical_reports', function (Blueprint $table) {
        $table->uuid('id')->primary();
        $table->foreignUuid('branch_id')->constrained('hospital_branches')->onDelete('cascade');
        $table->foreignUuid('patient_id')->constrained('patients')->onDelete('cascade');
        $table->foreignUuid('doctor_id')->nullable()->constrained('doctors')->onDelete('set null');
        $table->foreignUuid('appointment_id')->nullable()->constrained('appointments')->onDelete('set null');

        $table->enum('report_type', ['LAB', 'MEDICAL', 'DIAGNOSTIC']);
        $table->string('title');
        $table->string('file_url');
        $table->dateTime('uploaded_at');

        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medical_reports');
    }
};
