<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAbroadMissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('abroad_missions', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('role');
            $table->string('position_type');
            $table->string('letter_number');
            $table->date('letter_date');
            $table->text('mission_objective');
            $table->string('location');
            $table->date('mission_start_date');
            $table->date('mission_end_date');
            $table->integer('days_count');
            $table->integer('nights_count');
            $table->decimal('travel_allowance', 8, 2)->default(0);
            $table->decimal('pocket_money', 12, 2)->default(0); // Changed to accommodate larger values
            $table->decimal('total_pocket_money', 12, 2)->default(0); // Changed to accommodate larger values
            $table->decimal('meal_money', 12, 2)->default(0); // Changed to accommodate larger values
            $table->decimal('total_meal_money', 12, 2)->default(0); // Changed to accommodate larger values
            $table->decimal('accommodation_money', 12, 2)->default(0); // Changed to accommodate larger values
            $table->decimal('total_accommodation_money', 12, 2)->default(0); // Changed to accommodate larger values
            $table->decimal('final_total', 12, 2)->default(0);
            $table->timestamps();
        });
    }
    
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('abroad_missions');
    }
}
