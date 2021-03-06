<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePeriodosAcademicosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('periodos_academicos', function (Blueprint $table) {
            $table->increments('id');
            $table->date('fecha_inicio')->unique();
            $table->date('fecha_fin')->unique();
            $table->boolean('condicion');
           
            $table->timestamps();
        });

        DB::table('periodos_academicos')->insert(array('id'=>'1', 'fecha_inicio' => '2018-07-02', 'fecha_fin' => '2018-10-10', 'condicion' => true));  
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('periodos_academicos');
    }
}
