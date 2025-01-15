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
        if (!Schema::hasTable('certificate_data')) {
            Schema::create('certificate_data', function (Blueprint $table) {
                $table->increments('id', true);

                $table->unsignedBigInteger('report_key')->change();
                $table->foreignId('report_key')->references('id')->on('reports')->onDelete('cascade');

                $table->decimal('value_certificate', 15, 2)->default(0);

                $table->unsignedBigInteger('mission_type');
                $table->foreign('mission_type')->references('id')->on('mission_types')->onDelete('cascade');
                
                // Add the 'attachments' column as a JSON field
                $table->json('attachments')->nullable(); 

                $table->date('date_certificate');

                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('certificate_data');
    }
};
