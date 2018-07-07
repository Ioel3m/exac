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
            $table->string('cedula', 12);
            $table->string('nombres', 95);
            $table->string('apellidos', 95);
            $table->string('telefono', 12);
            $table->string('correo', 95);
            $table->boolean('condicion')->default(1);
            
            $table->integer('idalumno')->unsigned();
            $table->foreign('idalumno')->references('id')->on('users')->onDelete('cascade');
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
