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
    Schema::create('otp_tokens', function (Blueprint $table) {
        $table->uuid('id')->primary();
        $table->string('email');
        $table->string('otp_hash');
        $table->integer('attempts')->default(0);
        $table->integer('max_attempts')->default(5);
        $table->dateTime('used_at')->nullable();
        $table->dateTime('expires_at');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('otp_tokens');
    }
};
