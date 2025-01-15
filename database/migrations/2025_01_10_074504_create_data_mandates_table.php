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
        if (!Schema::hasTable('data_mandates')) {
            Schema::create('data_mandates', function (Blueprint $table) {
                $table->increments('id', true);

                // Foreign key for sub_account_key
                $table->unsignedBigInteger('sub_account_key')->change();
                $table->foreignId('sub_account_key')->references('id')->on('sub_account_keys')->onDelete('cascade');

                $table->string('report_key');

                $table->string('name_report_key')->nullable();
                $table->decimal('fin_law', 15, 2)->default(0);
                $table->decimal('current_loan', 15, 2)->default(0);

                // Foreign key for date_year
                $table->unsignedBigInteger('date_year');
                $table->foreign('date_year')->references('id')->on('years')->onDelete('cascade');

                $table->decimal('new_credit_status', 15, 2)->default(0);
                $table->decimal('early_balance', 15, 2)->default(0);
                $table->decimal('apply', 15, 2)->default(0);
                $table->decimal('deadline_balance', 15, 2)->default(0);
                $table->decimal('credit', 15, 2)->default(0);
                $table->decimal('law_average', 15, 2)->default(0);
                $table->decimal('law_correction', 15, 2)->default(0);

                $table->unique(['sub_account_key', 'report_key']);

                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_mandates');
    }
};
