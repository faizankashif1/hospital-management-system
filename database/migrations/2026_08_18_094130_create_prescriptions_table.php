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
    Schema::create('prescriptions', function (Blueprint $table) {
        $table->uuid('id')->primary();
        $table->foreignUuid('branch_id')->constrained('hospital_branches')->onDelete('cascade');
        $table->foreignUuid('appointment_id')->nullable()->constrained('appointments')->onDelete('set null');
        $table->foreignUuid('patient_id')->constrained('patients')->onDelete('cascade');
        $table->foreignUuid('doctor_id')->constrained('doctors')->onDelete('cascade');

        $table->text('notes')->nullable();
        $table->json('medications')->nullable();
        $table->string('file_url')->nullable();

        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prescriptions');
    }
};
