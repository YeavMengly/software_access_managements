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
                $table->increments('id');

                // Foreign key column
                $table->unsignedBigInteger('sub_account_key')->unique();
                $table->foreign('sub_account_key')->references('sub_account_key')->on('sub_account_keys')->onDelete('cascade');

                // $table->foreign('sub_account_key')->constrained('sub_account_keys')->onDelete('cascade');

                // Other columns
                $table->string('report_key');
                $table->string('name_report_key')->nullable();
                $table->decimal('fin_law', 15, 2)->default(0);
                $table->decimal('current_loan', 15, 2)->default(0);

                // Foreign key column for year_id
                $table->unsignedBigInteger('date_year');
                $table->foreign('date_year')->references('idZ')->on('years')->onDelete('cascade'); // Reference to years table

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
        Schema::dropIfExists('reports');
    }
};
