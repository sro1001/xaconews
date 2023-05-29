<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\NoticiaEstado;

class UpdateNoticiasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('noticias', function (Blueprint $table) {
            $table->dropColumn('revisada');
            $table->integer('estado_id')->unsigned()->default(NoticiaEstado::SIN_REVISAR)->after('texto');

            $table->foreign('estado_id')->references('id')->on('noticias_estados');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
