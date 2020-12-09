<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTimeslotsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('timeslots', function (Blueprint $table) {
            $table->integer('id', true)->unsigned()->increments('id');
            $table->integer('cinema_id')->unsigned();
            $table->integer('film_id')->unsigned();
            $table->time('time_slot');
            $table->date('date_slot');

            $table->foreign('cinema_id')->references('id')->on('cinemas');
            $table->foreign('film_id')->references('id')->on('films');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('timeslots');
    }
}
