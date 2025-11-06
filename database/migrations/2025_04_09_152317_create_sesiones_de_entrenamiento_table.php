<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSesionesDeEntrenamientoTable extends Migration
{
    public function up()
    {
        Schema::create('sesiones_de_entrenamiento', function (Blueprint $table) {
            $table->id('ses_id');
            $table->date('ses_fecha');
            $table->string('ses_tipo');
            $table->unsignedBigInteger('ses_equipo');
            $table->timestamps();

            $table->foreign('ses_equipo')->references('equ_id')->on('equipos')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('sesiones_de_entrenamiento');
    }
}
