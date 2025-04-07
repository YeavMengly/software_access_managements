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
        Schema::create('title_usage_unit_waters', function (Blueprint $table) {
            $table->id();
            $table->string('title_usage_unit_water')->nullable();
            $table->string('location_number_water')->nullable();
            $table->string('province_city');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('title_usage_unit_waters');
    }
};
