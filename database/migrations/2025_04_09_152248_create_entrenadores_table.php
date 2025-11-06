<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEntrenadoresTable extends Migration
{
    public function up()
    {
        Schema::create('entrenadores', function (Blueprint $table) {
            $table->id('ent_id');
            $table->string('ent_nombre');
            $table->string('ent_apellido');
            $table->string('ent_email')->unique();
            $table->string('ent_password');
            $table->string('rol')->default('entrenador'); // por defecto 'entrenador'
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('entrenadores');
    }
}
