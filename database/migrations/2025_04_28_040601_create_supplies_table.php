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
        Schema::create('supplies', function (Blueprint $table) {
            $table->id();
            $table->string('supplie_id');
            $table->date('date');
            $table->string('receipt_number');
            $table->text('description');
            $table->string('unit');
            $table->decimal('quantity', 15, 0)->default(0);
            $table->decimal('quantity_used', 15, 0)->default(0);
            $table->decimal('remain_supplie', 15, 0)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('supplies');
    }
};
