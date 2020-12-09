<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCinemaFilmTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cinema_film', function (Blueprint $table) {
            $table->integer('cinema_id')->unsigned();
            $table->integer('film_id')->unsigned();
            
            $table->primary(['cinema_id', 'film_id']);

            $table->foreign('cinema_id')->references('id')->on('cinemas');
            $table->foreign('film_id')->references('id')->on('films');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cinema_film');
    }
}
