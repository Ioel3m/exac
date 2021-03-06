<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAsistenciasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('asistencias', function (Blueprint $table) {
            $table->increments('id');
            $table->boolean('asistio')->default(1);
            $table->boolean('fuga')->default(0);
            $table->string('observacion', 100)->nullable();

            $table->integer('idalumno')->unsigned();
            $table->foreign('idalumno')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');

            $table->integer('idclase')->unsigned();
            $table->foreign('idclase')->references('id')->on('clases')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('asistencias');
    }
}
