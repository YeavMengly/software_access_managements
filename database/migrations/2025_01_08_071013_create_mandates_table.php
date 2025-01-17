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
        // Check if the 'mandates' table exists
        if (!Schema::hasTable('mandates')) {
            Schema::create('mandates', function (Blueprint $table) {
                $table->increments('id');

                $table->unsignedBigInteger('report_key')->change();
                $table->foreignId('report_key')->references('id')->on('reports')->onDelete('cascade');

                $table->decimal('value_mandate', 15, 2)->default(0);

                $table->unsignedBigInteger('mission_type');
                $table->foreign('mission_type')->references('id')->on('mission_types')->onDelete('cascade');

                $table->json('attachments')->nullable();
                
                $table->date('date_mandate');

                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mandates');
    }
};
