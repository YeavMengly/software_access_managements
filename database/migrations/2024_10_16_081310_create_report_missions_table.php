<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReportMissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('report_missions', function (Blueprint $table) {
            $table->id();
            $table->string('id_number')->nullable(); // For 'ល.រ' - ID number
            $table->string('name_khmer')->nullable(); // For 'ឈ្មោះ - ខ្មែរ' - Name in Khmer
            $table->string('name_latin')->nullable(); // For 'ឈ្មោះ - ឡាតាំង' - Name in Latin
            $table->string('account_number')->nullable(); // For 'លេខគណនី' - Account number
            $table->timestamps(); // Adds created_at and updated_at timestamps
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('report_missions');
    }
}
