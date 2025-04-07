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
        if (!Schema::hasTable('fuel_totals')) {
            Schema::create('fuel_totals', function (Blueprint $table) {
                $table->id();
                $table->string('company_name'); // បញ្ចូលឈ្មោះក្រុមហ៊ុន
                $table->date('release_date'); // កាលបរិច្ឆេទចេញផ្សាយ
                $table->string('refers');   //  យោង
                $table->string('description');  //  ពណ៍នា
                $table->string('warehouse_entry_number');
                $table->string('warehouse'); // សារពើភ័ណ្ឌ
                $table->string('product_name'); 
                $table->integer('quantity'); 
                $table->decimal('unit_price', 10, 0); // 10 digits total, 2 decimal places
                $table->decimal('fuel_total', 12, 0); // More space for total value
                
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fuel_totals');

        // Schema::table('fuel_totals', function (Blueprint $table) {
        //     $table->integer('quantity')->change(); // Adjust to previous type if necessary
        //     $table->decimal('unit_price', 10, 0)->change();
        //     $table->decimal('fuel_total', 10, 0)->change();
        // });
    }
};
