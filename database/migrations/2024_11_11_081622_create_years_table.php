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
        if (!Schema::hasTable('years')) {
            Schema::create('years', function (Blueprint $table) {
                $table->id();
                $table->date('date_year'); // Stores the year as a date (e.g., 'YYYY-01-01')
                $table->enum('status', ['active', 'inactive', 'pending'])->default('active');

                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('years')) {
            Schema::dropIfExists('years');
        }
    }
};
