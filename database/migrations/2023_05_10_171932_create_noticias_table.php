<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNoticiasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('noticias', function (Blueprint $table) {
            $table->increments('id');
            $table->string('titulo');
            $table->text('url');
            $table->integer('bien_interes_cultural_id')->unsigned();
            $table->integer('fuente_id')->unsigned();
            $table->datetime('fecha');
            $table->text('google_news_id');
            $table->longText('texto');
            $table->boolean('revisada')->default('0');
            $table->timestamps();

            $table->foreign('bien_interes_cultural_id')->references('id')->on('bienes_interes_cultural');
            $table->foreign('fuente_id')->references('id')->on('fuentes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('noticias');
    }
}
