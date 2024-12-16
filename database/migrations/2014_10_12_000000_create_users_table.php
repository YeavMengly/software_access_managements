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
        if (!Schema::hasTable('users')) {
            Schema::create('users', function (Blueprint $table) {
                $table->id();
                $table->string('name'); // User name
                $table->string('phone_number')->unique(); // Phone number, unique for each user
                $table->string('password'); // Password
                $table->string('role')->default('user'); // Role with default value 'user'
                // $table->timestamp('last_login_at')->nullable()->after('updated_at');
                $table->rememberToken(); // Remember token for authentication
                $table->timestamps(); // Timestamps for created_at and updated_at
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
