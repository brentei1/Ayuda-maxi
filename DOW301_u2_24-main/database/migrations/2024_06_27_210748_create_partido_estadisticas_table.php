<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePartidoEstadisticasTable extends Migration
{
    public function up()
    {
        Schema::create('estadisticas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('partido_id');
            $table->integer('puntos_local');
            $table->integer('puntos_visitante');
            $table->integer('rebotes_local');
            $table->integer('rebotes_visitante');
            $table->integer('asistencias_local');
            $table->integer('asistencias_visitante');
            $table->integer('robos_local');
            $table->integer('robos_visitante');
            $table->integer('tapones_local');
            $table->integer('tapones_visitante');
            $table->integer('faltas_local');
            $table->integer('faltas_visitante');
            $table->integer('perdidas_local');
            $table->integer('perdidas_visitante');
            $table->float('tiros_de_campo_local', 4, 2);
            $table->float('tiros_de_campo_visitante', 4, 2);
            $table->float('triples_local', 4, 2);
            $table->float('triples_visitante', 4, 2);
            $table->float('tiros_libres_local', 4, 2);
            $table->float('tiros_libres_visitante', 4, 2);
            $table->integer('lesiones_local');
            $table->integer('lesiones_visitante');
            $table->integer('cambios_local');
            $table->integer('cambios_visitante');
            $table->timestamps();

            $table->foreign('partido_id')->references('id')->on('partidos');
        });
    }

    public function down()
    {
        Schema::dropIfExists('partido_estadisticas');
    }
}