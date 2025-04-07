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
        if (!Schema::hasTable('waters')) {
            Schema::create('waters', function (Blueprint $table) {
                $table->id();
                $table->string('usage_unit_water');  // ឈ្មោះអង្គភាពប្រើប្រាស់
                $table->string('location_number_water')->nullable();    // លេខទីតាំង
                $table->string('invoice_number')->nullable();   // វិក្កយបត្រ  
                $table->date('usage_date')->nullable();     // កាលបរិច្ឆេទ
                $table->date('usage_start')->nullable();    // រយៈពេលចាប់ផ្ដើម
                $table->date('usage_end')->nullable();  // រយៈពេលបញ្ចប់
                $table->decimal('kilowatt_water', 10, 0)->default(0);  // ថាមពលគីឡូវ៉ាត់
                $table->decimal('total_cost', 15, 0)->default(0);     // ប្រាក់សរុបជារៀល
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('waters');
    }
};
