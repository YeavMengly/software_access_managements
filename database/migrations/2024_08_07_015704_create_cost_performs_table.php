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
        if (!Schema::hasTable('cost_performs')) {
            Schema::create('cost_performs', function (Blueprint $table) {
                $table->increments('id', true);

                $table->unsignedBigInteger('code')->change();
                $table->foreignId('code')->references('id')->on('keys')->onDelete('cascade');

                $table->unsignedBigInteger('fin_law')->change();
                $table->foreignId('fin_law')->references('id')->on('reports')->onDelete('cascade');

                $table->double('new_loan')->default(0);
                $table->double('pay_in')->default(0);
                $table->double('perform_in')->default(0);
                $table->double('compare_avg_one')->default(0);
                $table->double('guarenty')->default(0);
                $table->double('compare_avg_two')->default(0);



                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cost_performs');
    }
};
