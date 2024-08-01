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
        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sub_account_key_id')->change();
            $table->foreignId('sub_account_key_id')->constrained('sub_account_keys')->onDelete('cascade');
            $table->string('report_key');
            $table->string('name_report_key');
            $table->decimal('fin_law', 15, 2)->nullable();
            $table->decimal('current_loan', 15, 2)->nullable();
            $table->decimal('internal_increase', 15, 2)->nullable();
            $table->decimal('unexpected_increase', 15, 2)->nullable();
            $table->decimal('additional_increase', 15, 2)->nullable();
            $table->decimal('decrease', 15, 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};
