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
        if (!Schema::hasTable('title_usage_units')) {
            Schema::create('title_usage_units', function (Blueprint $table) {
                $table->increments('id', true);
                $table->string('title_usage_unit')->nullable();
                $table->string('location_number')->nullable();
                $table->string('province_city');
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('title_usage_units');
    }
};
