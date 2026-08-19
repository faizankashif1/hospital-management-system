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
    Schema::create('hospital_branches', function (Blueprint $table) {
        $table->uuid('id')->primary();
        $table->foreignUuid('hospital_id')->constrained('hospitals')->onDelete('cascade');
        $table->string('name');
        $table->string('city');
        $table->text('address');
        $table->string('phone');
        $table->enum('status', ['ACTIVE', 'SUSPENDED', 'CLOSED'])->default('ACTIVE');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hospital_branches');
    }
};
