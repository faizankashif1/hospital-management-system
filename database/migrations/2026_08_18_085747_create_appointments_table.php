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
    Schema::create('appointments', function (Blueprint $table) {
        $table->uuid('id')->primary();
        $table->foreignUuid('branch_id')->constrained('hospital_branches')->onDelete('cascade');
        $table->foreignUuid('patient_id')->constrained('patients')->onDelete('cascade');
        $table->foreignUuid('doctor_id')->constrained('doctors')->onDelete('cascade');
        $table->foreignUuid('department_id')->constrained('departments')->onDelete('cascade');

        $table->date('appointment_date');
        $table->time('appointment_time');
        $table->integer('duration_minutes');

        $table->enum('type', ['CONSULTATION', 'FOLLOW_UP', 'EMERGENCY', 'WALK_IN']);
        $table->enum('priority', ['LOW', 'NORMAL', 'HIGH', 'URGENT'])->default('NORMAL');
        $table->enum('status', [
            'PENDING', 'CONFIRMED', 'CHECKED_IN', 'IN_PROGRESS',
            'COMPLETED', 'CANCELLED', 'NO_SHOW'
        ])->default('PENDING');

        $table->text('reason')->nullable();

        $table->decimal('deposit_amount', 10, 2)->default(0);
        $table->enum('payment_status', ['PENDING', 'PAID', 'REFUNDED', 'FORFEITED'])->default('PENDING');

        $table->enum('cancelled_by', ['DOCTOR', 'ADMIN', 'RECEPTIONIST', 'PATIENT'])->nullable();
        $table->string('cancellation_reason', 50)->nullable();

        $table->boolean('deposit_refunded')->default(false);
        $table->decimal('refund_amount', 10, 2)->nullable();

        $table->dateTime('checked_in_at')->nullable();
        $table->dateTime('actual_start_time')->nullable();
        $table->dateTime('actual_end_time')->nullable();

        $table->string('queue_number', 20)->nullable();
        $table->integer('estimated_wait_minutes')->nullable();

        $table->timestamps();

        $table->index(['doctor_id', 'appointment_date', 'appointment_time']);
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
