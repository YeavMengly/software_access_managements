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
        if (!Schema::hasTable('electrics')) {
            Schema::create('electrics', function (Blueprint $table) {
                $table->increments('id', true);

                $table->string('usage_unit'); // Change from unsignedBigInteger to string
                $table->string('location_number')->nullable();
                $table->date('usage_date')->nullable();     // កាលបរិច្ឆេទ
                $table->date('usage_start')->nullable();    // រយៈពេលចាប់ផ្ដើម
                $table->date('usage_end')->nullable();  // រយៈពេលបញ្ចប់
                $table->decimal('kilowatt_energy', 10, 0)->default(0);  // ថាមពលគីឡូវ៉ាត់
                $table->decimal('reactive_energy', 10, 0)->default(0);  // ថាមពលរ៉េអាក់ទិក
                $table->decimal('total_amount', 15, 0)->default(0);     // ប្រាក់សរុបជារៀល
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('electrics');
    }
};
