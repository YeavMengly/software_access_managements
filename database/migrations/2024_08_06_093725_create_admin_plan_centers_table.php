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
        if (!Schema::hasTable('admin_plan_centers')) {
            Schema::create('admin_plan_centers', function (Blueprint $table) {
                $table->increments('id', true);

                $table->unsignedBigInteger('code')->change();
                $table->foreignId('code')->references('id')->on('keys')->onDelete('cascade');

                $table->double('accord_content')->default(0);
                $table->double('fin_law')->default(0);
                $table->double('total')->default(0);
                $table->double('total_april')->default(0);
                $table->double('total_may')->default(0);
                $table->double('total_june')->default(0);
                $table->double('sth')->default(0);

                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admin_plan_centers');
    }
};
