<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNoticiasSentimientosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('noticias_sentimientos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('noticia_id')->unsigned();
            $table->integer('sentimiento_id')->unsigned();
            $table->integer('puntuacion');

            $table->foreign('noticia_id')->references('id')->on('noticias');
            $table->foreign('sentimiento_id')->references('id')->on('sentimientos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('noticias_sentimientos');
    }
}
