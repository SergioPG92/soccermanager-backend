<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateParticipacionesTable extends Migration
{
    public function up()
    {
        Schema::create('participaciones', function (Blueprint $table) {
            $table->id('par_id');
            $table->unsignedBigInteger('par_jugador');
            $table->unsignedBigInteger('par_sesion');
            $table->decimal('par_nota', 4, 2)->nullable();
            $table->timestamps();

            $table->foreign('par_jugador')->references('jug_id')->on('jugadores')->onDelete('cascade');
            $table->foreign('par_sesion')->references('ses_id')->on('sesiones_de_entrenamiento')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('participaciones');
    }
}
