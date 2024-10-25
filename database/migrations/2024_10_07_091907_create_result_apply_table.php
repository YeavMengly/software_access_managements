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
        Schema::create('result_apply', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->string('report_key');
            $table->decimal('fin_law', 10, 2)->default(0);
            $table->decimal('current_loan', 10, 2)->default(0);
            $table->decimal('decrease', 10, 2)->default(0);
            $table->decimal('new_credit_status', 10, 2)->default(0);
            $table->decimal('early_balance', 10, 2)->default(0);
            $table->decimal('apply', 10, 2)->default(0);
            $table->decimal('total_increase', 10, 2)->default(0);
            $table->decimal('total_sum_refer', 10, 2)->default(0);
            $table->decimal('total_remain', 10, 2)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('result_apply');
    }
};
