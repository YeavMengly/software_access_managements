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
        Schema::create('result_f_m_c_s', function (Blueprint $table) {
            $table->id();
            $table->string('sub_account_key'); // Assuming this is a string
            $table->string('report_key');     // Assuming this is a string
            $table->decimal('fin_law', 15, 2); // Adjust precision and scale as needed
            $table->decimal('v_mandate', 15, 2); // Adjust precision and scale as needed
            $table->decimal('v_certificate', 15, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('result_f_m_c_s');
    }
};
