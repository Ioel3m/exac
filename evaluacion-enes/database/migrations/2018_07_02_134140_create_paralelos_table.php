<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateParalelosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('paralelos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('denominacion', 12);
            $table->string('descripcion', 100);
            $table->boolean('condicion');
            $table->integer('idperiodo')->unsigned();
            $table->foreign('idperiodo')->references('id')->on('periodos_academicos')->onDelete('cascade');

            $table->timestamps();
        });

        DB::table('paralelos')->insert(array('id'=>'1', 'denominacion' => '', 'descripcion' => 'GENERAL', 'condicion' => true, 'idperiodo' => '1'));  
        DB::table('paralelos')->insert(array('id'=>'2', 'denominacion' => 'A', 'descripcion' => 'ALUMNOS Y DOCENTESDE MATEMÁTICAS', 'condicion' => true, 'idperiodo' => '2'));  
        DB::table('paralelos')->insert(array('id'=>'3', 'denominacion' => 'B', 'descripcion' => 'ALUMNOS Y DOCENTES DE ABSTRACTA', 'condicion' => true, 'idperiodo' => '2'));  
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('paralelos');
    }
}
