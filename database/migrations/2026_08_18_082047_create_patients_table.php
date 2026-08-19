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
    Schema::create('patients', function (Blueprint $table) {
        $table->uuid('id')->primary();
        $table->foreignUuid('user_id')->nullable()->unique()->constrained('users')->onDelete('set null');
        $table->string('blood_group', 5)->nullable();
        $table->string('insurance_provider')->nullable();
        $table->string('insurance_policy_no')->nullable();
        $table->string('emergency_name');
        $table->string('emergency_relation');
        $table->string('emergency_contact');
        $table->text('emergency_address')->nullable();
        $table->integer('no_show_count')->default(0);
        $table->date('last_no_show_date')->nullable();
        $table->boolean('booking_restricted')->default(false);
        $table->decimal('required_deposit', 10, 2)->default(0);
        $table->timestamps();
    });
}
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patients');
    }
};
