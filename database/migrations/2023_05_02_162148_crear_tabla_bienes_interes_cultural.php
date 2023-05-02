<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CrearTablaBienesInteresCultural extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bienes_interes_cultural', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre');
            $table->text('descripción')->nullable();
            $table->integer('municipio_id')->unsigned();
            $table->integer('localidad_id')->unsigned();
            $table->integer('provincia_id')->unsigned();

            $table->foreign('municipio_id')->references('id')->on('municipios');
            $table->foreign('localidad_id')->references('id')->on('localidades');
            $table->foreign('provincia_id')->references('id')->on('provincias');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bienes_interes_cultural');
    }
}
