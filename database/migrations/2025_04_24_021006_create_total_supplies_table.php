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
        if (!Schema::hasTable('total_supplies')) {
            Schema::create('total_supplies', function (Blueprint $table) {
                $table->id();
                $table->string('company_name'); // បញ្ចូលឈ្មោះក្រុមហ៊ុន
                $table->date('release_date'); // កាលបរិច្ឆេទចេញផ្សាយ
                $table->string('refers');   //  យោង
                $table->string('description');  //  ពណ៍នា
                $table->string('warehouse'); // សារពើភ័ណ្ឌ
                $table->text('product_name');
                $table->string('unit');
                $table->integer('quantity');
                $table->decimal('unit_price', 12, 0);
                $table->decimal('total_price', 12, 0);
                $table->string('source')->nullable();
                $table->date('production_year')->nullable();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('total_supplies');
    }
};
