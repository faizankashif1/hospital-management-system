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
    Schema::create('waitlist_entries', function (Blueprint $table) {
        $table->uuid('id')->primary();
        $table->foreignUuid('branch_id')->constrained('hospital_branches')->onDelete('cascade');
        $table->foreignUuid('patient_id')->constrained('patients')->onDelete('cascade');
        $table->foreignUuid('doctor_id')->nullable()->constrained('doctors')->onDelete('cascade');
        $table->foreignUuid('department_id')->constrained('departments')->onDelete('cascade');

        $table->date('preferred_date');
        $table->enum('priority', ['LOW', 'NORMAL', 'HIGH', 'URGENT'])->default('NORMAL');
        $table->enum('status', ['WAITING', 'PROMOTED', 'EXPIRED', 'CANCELLED'])->default('WAITING');

        $table->dateTime('promoted_at')->nullable();
        $table->dateTime('expires_at')->nullable();

        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('waitlist_entries');
    }
};
