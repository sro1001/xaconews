<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSincronizacionNoticiasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sincronizacion_noticias', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('limite_llamadas_api_noticias');
            $table->integer('limite_llamadas_chatGPT');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sincronizacion_noticias');
    }
}
