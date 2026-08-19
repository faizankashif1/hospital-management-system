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
    Schema::create('history_records', function (Blueprint $table) {
        $table->uuid('id')->primary();
        $table->foreignUuid('branch_id')->constrained('hospital_branches')->onDelete('cascade');
        $table->foreignUuid('patient_id')->constrained('patients')->onDelete('cascade');
        $table->foreignUuid('doctor_id')->nullable()->constrained('doctors')->onDelete('set null');

        $table->enum('type', ['APPOINTMENT', 'VISIT', 'DIAGNOSIS', 'PRESCRIPTION', 'REPORT', 'PAYMENT']);
        $table->string('title');
        $table->text('description')->nullable();
        $table->enum('status', ['ACTIVE', 'ARCHIVED'])->default('ACTIVE');
        $table->json('metadata')->nullable();

        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('history_records');
    }
};
