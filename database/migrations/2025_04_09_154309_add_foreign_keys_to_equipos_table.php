<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToEquiposTable extends Migration
{
    public function up()
    {
        Schema::table('equipos', function (Blueprint $table) {
            $table->unsignedBigInteger('equ_entrenador')->nullable()->change();

            $table->foreign('equ_entrenador', 'fk_equipos_entrenador')
                ->references('ent_id')
                ->on('entrenadores')
                ->nullOnDelete(); 
        });
    }

    public function down()
    {
        Schema::table('equipos', function (Blueprint $table) {
            $table->dropForeign('fk_equipos_entrenador');
        });
    }
}

