<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEquiposTable extends Migration
{
    public function up()
    {
        Schema::create('equipos', function (Blueprint $table) {
            $table->id('equ_id');
            $table->string('equ_nombre');
            $table->unsignedBigInteger('equ_entrenador')->nullable(); 
            $table->timestamps();
            $table->foreign('equ_entrenador')->references('ent_id')->on('entrenadores')->nullOnDelete();
        });
    }

    public function down()
    {
        Schema::dropIfExists('equipos');
    }
}
