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
        Schema::create('report_key_totals', function (Blueprint $table) {
            $table->id();
            $table->string('report_key_prefix'); // To store the prefix (e.g., '321', '322')
            $table->decimal('fin_law', 15, 2)->default(0); // For financial law total
            $table->decimal('current_loan', 15, 2)->default(0); // For current loan total
            $table->decimal('decrease', 15, 2)->default(0); // For decrease total
            $table->decimal('new_credit_status', 15, 2)->default(0); // For new credit status total
            $table->decimal('early_balance', 15, 2)->default(0); // For early balance total
            $table->decimal('apply', 15, 2)->default(0); // For apply total
            $table->decimal('total_increase', 15, 2)->default(0); // For total increase
            $table->decimal('total_sum_refer', 15, 2)->default(0); // For total sum refer
            $table->decimal('total_remain', 15, 2)->default(0); // For total remain
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('report_key_totals');
    }
};
