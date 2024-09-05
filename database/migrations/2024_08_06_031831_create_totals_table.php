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
        if (!Schema::hasTable('totals')) {
            Schema::create('totals', function (Blueprint $table) {
                $table->increments('id', true);

                $table->unsignedBigInteger('code')->change();
                $table->foreignId('code')->references('id')->on('keys')->onDelete('cascade');


                $table->unsignedBigInteger('fin_law')->change();
                $table->foreignId('fin_law')->references('id')->on('reports')->onDelete('cascade');

                $table->double('new_loan')->default(0);
                $table->double('cost_early_balance')->default(0);
                $table->double('cost_apply')->default(0);
                $table->double('cost_average_one')->default(0);
                $table->double('cost_sum_ref')->default(0);
                $table->double('cost_average_two')->default(0);
                $table->double('cost_remain')->default(0);
                $table->double('req_mandate_early_balance')->default(0);
                $table->double('req_mandate_apply')->default(0);
                $table->double('req_mandate_average_one')->default(0);
                $table->double('req_mandate_sum_ref')->default(0);
                $table->double('req_mandate_average_two')->default(0);
                $table->double('req_mandate_remain')->default(0);
                $table->double('millions_riel')->default(0);


                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('totals');
    }
};
