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
        if (!Schema::hasTable('reports')) {
            Schema::create('reports', function (Blueprint $table) {
                $table->increments('id'); // Auto-incrementing primary key

                // Foreign key column
                $table->unsignedBigInteger('sub_account_key')->change();
                $table->foreignId('sub_account_key')->references('id')->on('sub_account_keys')->onDelete('cascade');

                // Other columns
                $table->string('report_key');
                $table->string('name_report_key')->nullable(); // Allow null if not required
                $table->decimal('fin_law', 15, 2)->default(0);
                $table->decimal('current_loan', 15, 2)->default(0);


                $table->decimal('new_credit_status', 15, 2)->default(0); // Calculated as (current_loan + total_increase - decrease - editorial)
                $table->decimal('early_balance', 15, 2)->default(0); // Sumif calculation
                $table->decimal('apply', 15, 2)->default(0);
                $table->decimal('deadline_balance', 15, 2)->default(0); // Calculated as (early_balance + apply)
                $table->decimal('credit', 15, 2)->default(0); // Calculated as (new_credit_status - deadline_balance)
                $table->decimal('law_average', 15, 2)->default(0); // Calculated as (fin_law / deadline_balance)
                $table->decimal('law_correction', 15, 2)->default(0); // Calculated as (new_credit_status / deadline_balance)
                // Unique constraint for the combination of sub_account_key and report_key
                // $table->unique(['sub_account_key', 'report_key']);

                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};
