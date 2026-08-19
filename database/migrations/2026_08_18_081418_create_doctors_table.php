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
    Schema::create('doctors', function (Blueprint $table) {
        $table->uuid('id')->primary();
        $table->foreignUuid('user_id')->unique()->constrained('users')->onDelete('cascade');
        $table->foreignUuid('branch_id')->constrained('hospital_branches')->onDelete('cascade');
        $table->foreignUuid('department_id')->nullable()->constrained('departments')->onDelete('set null');
        $table->string('specialization')->nullable();
        $table->string('qualification')->nullable();
        $table->string('license_no')->unique();
        $table->decimal('consultation_fee', 10, 2)->default(0);
        $table->json('available_days')->nullable();
        $table->integer('experience_years')->nullable();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('doctors');
    }
};
