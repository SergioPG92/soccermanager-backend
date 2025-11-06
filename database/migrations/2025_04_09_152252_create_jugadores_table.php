<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJugadoresTable extends Migration
{
    public function up()
    {
        Schema::create('jugadores', function (Blueprint $table) {
            $table->id('jug_id');
            $table->string('jug_nombre');
            $table->string('jug_apellido');
            $table->integer('jug_edad');
            $table->string('jug_posicion');
            $table->string('jug_estado'); 
            $table->unsignedBigInteger('jug_equipo');
            $table->timestamps();

            $table->foreign('jug_equipo')->references('equ_id')->on('equipos')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('jugadores');
    }
}
