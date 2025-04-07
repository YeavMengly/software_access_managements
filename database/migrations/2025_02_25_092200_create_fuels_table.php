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
            throw new Exception('fuel_totals table does not exist. Run its migration first.');
        }

        Schema::create('fuels', function (Blueprint $table) {
            $table->id();
            $table->date('fuel_date')->nullable(); // Allow NULL values
            $table->date('date');
            $table->string('receipt_number')->unique();
            $table->text('description')->nullable();
            $table->unsignedBigInteger('fuel_total_id')->nullable();
            $table->foreign('fuel_total_id')->references('id')->on('fuel_totals')->onDelete('cascade');
            $table->json('oil_type');
            $table->json('quantity');
            $table->json('quantity_used')->nullable(); // Make it nullable
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fuels');
    }
};
