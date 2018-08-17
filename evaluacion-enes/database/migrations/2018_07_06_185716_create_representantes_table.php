<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRepresentantesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('representantes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('cedula', 12)->nullable();
            $table->string('nombres', 95)->nullable();
            $table->string('apellidos', 95)->nullable();
            $table->string('telefono', 12)->nullable();
            $table->string('correo', 95)->nullable();
            $table->boolean('condicion')->default(1);
            
            $table->integer('idalumno')->unsigned();
            $table->foreign('idalumno')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('representantes');
    }
}
