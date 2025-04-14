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
        Schema::create('user', function (Blueprint $table) {
            $table->id();  // Auto-incrementing ID
            $table->string('name');  // Name field
            $table->string('email')->unique();  // Unique email field
            $table->timestamp('email_verified_at')->nullable();  // Email verification timestamp
            $table->string('password');  // Password field
            $table->rememberToken();  // For "remember me" functionality
            $table->enum('role', ['admin', 'buyer'])->default('buyer');  // Role column with default value as 'buyer'
            $table->timestamps();  // Created at and updated at timestamps
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user');  // Drop the users table if rolling back
    }
};
