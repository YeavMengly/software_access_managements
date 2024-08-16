<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNewMissionTable extends Migration
{
    public function up()
    {
        Schema::create('new_missions', function (Blueprint $table) {
            $table->id();
            $table->string('letter_number');
            $table->date('letter_date');
            $table->string('mission_objective');
            $table->string('place');
            $table->string('location');
            $table->date('mission_start_date');
            $table->date('mission_end_date');
            $table->integer('num_people');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('new_missions');
    }
}
