<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CrearTablaUsuarios extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre_completo');
            $table->string('email');
            $table->integer('rol_id')->unsigned();
            $table->string('password');
            $table->string('telefono')->nullable();
            $table->boolean('activo')->default('1');
            $table->timestamps();

            $table->foreign('rol_id')->references('id')->on('roles');
            $table->unique(array('email','telefono'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
