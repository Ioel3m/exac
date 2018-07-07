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
            $table->string('descripcion', 100);
            $table->boolean('condicion');
            
            $table->timestamps();
        });

        DB::table('paralelos')->insert(array('id'=>'1', 'descripcion' => 'GENERAL', 'condicion' => true));  
        DB::table('paralelos')->insert(array('id'=>'2', 'descripcion' => 'A', 'condicion' => true));  
        DB::table('paralelos')->insert(array('id'=>'3', 'descripcion' => 'B', 'condicion' => true));  
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
