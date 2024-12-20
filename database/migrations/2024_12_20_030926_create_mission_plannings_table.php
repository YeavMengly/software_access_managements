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
        if (!Schema::hasTable('mission_plannings')) {
            Schema::create('mission_plannings', function (Blueprint $table) {
                $table->id();

                $table->unsignedBigInteger('sub_account_key');
                $table->foreign('sub_account_key')->references('id')->on('sub_account_keys')->onDelete('cascade');


                // Define report_key as unsignedBigInteger and foreign key
                $table->unsignedBigInteger('report_key');
                $table->foreign('report_key')->references('id')->on('reports')->onDelete('cascade');

                $table->decimal('pay_mission', 15, 2)->default(0);

                // Define mission_type as unsignedBigInteger and foreign key
                $table->unsignedBigInteger('mission_type');
                $table->foreign('mission_type')->references('id')->on('mission_types')->onDelete('cascade');

                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mission_plannings');
    }
};
