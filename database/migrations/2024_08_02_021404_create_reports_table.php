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
                $table->increments('id', true);

                $table->unsignedBigInteger('sub_account_key')->change();
                $table->foreignId('sub_account_key')->references('id')->on('sub_account_keys')->onDelete('cascade');

                $table->string('report_key');
                $table->string('name_report_key');
                $table->decimal('fin_law', 15, 2)->default(0);
                $table->decimal('current_loan', 15, 2)->default(0); // get from early-balance to new months
                $table->decimal('internal_increase', 15, 2)->default(0);
                $table->decimal('unexpected_increase', 15, 2)->default(0);
                $table->decimal('additional_increase', 15, 2)->default(0);
                $table->decimal('total_increase', 15, 2)->default(0);   //sum (internal_increase, unexpected_increase, additional_increase )
                $table->decimal('decrease', 15, 2)->default(0); // 
                $table->decimal('editorial', 15, 2)->default(0);    // 
                $table->decimal('new_credit_status', 15, 2)->default(0); //  (current_loan + total_increase - decrease - editorial)
                $table->decimal('early_balance', 15, 2)->default(0);  //   calcualte sumif
                $table->decimal('apply', 15, 2)->default(0); //  select form another
                $table->decimal('deadline_balance', 15, 2)->default(0);  // (early_balance + apply)
                $table->decimal('credit', 15, 2)->default(0);        // (new_credit_status - deadline_balance)
                $table->decimal('law_average')->default(0);   //  (fin_law / deadline_balance )
                $table->decimal('law_correction')->default(0);   //  (new_credit_status / deadline_balance)

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
