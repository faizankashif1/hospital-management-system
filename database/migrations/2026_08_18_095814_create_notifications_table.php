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
    Schema::create('notifications', function (Blueprint $table) {
        $table->uuid('id')->primary();
        $table->foreignUuid('branch_id')->constrained('hospital_branches')->onDelete('cascade');
        $table->foreignUuid('user_id')->constrained('users')->onDelete('cascade');
        $table->foreignUuid('appointment_id')->nullable()->constrained('appointments')->onDelete('set null');

        $table->enum('channel', ['EMAIL', 'SMS', 'IN_APP']);
        $table->enum('fallback_channel', ['EMAIL', 'SMS', 'IN_APP'])->nullable();
        $table->text('message');
        $table->enum('status', ['PENDING', 'SENT', 'FAILED', 'CANCELLED'])->default('PENDING');
        $table->dateTime('scheduled_for');
        $table->dateTime('sent_at')->nullable();

        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
