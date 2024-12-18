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
        Schema::create('summary_reports', function (Blueprint $table) {
            $table->increments('id', true);
            $table->string('program'); 
            $table->decimal('fin_law', 15, 2);
            $table->decimal('current_loan', 15, 2); 
            $table->decimal('total_increase', 15, 2); 
            $table->decimal('decrease', 15, 2); 
            $table->decimal('new_credit_status', 15, 2); 
            $table->decimal('total_early_balance', 15, 2); 
            $table->decimal('avg_total_early_balance');
            $table->decimal('total_apply', 15, 2);
            $table->decimal('avg_total_apply');
            $table->decimal('total_sum_refer', 15, 2); 
            $table->decimal('avg_total_sum_refer');
            $table->decimal('total_remain', 15, 2);  
            $table->decimal('avg_total_remain');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('summary_reports');
    }
};
