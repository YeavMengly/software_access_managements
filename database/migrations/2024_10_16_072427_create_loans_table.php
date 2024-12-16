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
        if (!Schema::hasTable('loans')) {
            Schema::create('loans', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('sub_account_key')->change();
                $table->foreignId('sub_account_key')->references('id')->on('sub_account_keys')->onDelete('cascade');
                
                $table->unsignedBigInteger('report_key')->change();
                $table->foreignId('report_key')->references('id')->on('reports')->onDelete('cascade');

                $table->decimal('internal_increase', 15, 2)->default(0);
                $table->decimal('unexpected_increase', 15, 2)->default(0);
                $table->decimal('additional_increase', 15, 2)->default(0);
                $table->decimal('total_increase', 15, 2)->default(0);  
                $table->decimal('decrease', 15, 2)->default(0);
                $table->decimal('editorial', 15, 2)->default(0);
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loans');
    }
};
