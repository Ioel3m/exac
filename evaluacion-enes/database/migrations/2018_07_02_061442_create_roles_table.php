<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('descripcion', 100)->unique();
        });
        
        DB::table('roles')->insert(array('id'=>'1', 'descripcion' => 'ADMINISTRADOR'));  
        DB::table('roles')->insert(array('id'=>'2', 'descripcion' => 'ESTUDIANTE'));  
        DB::table('roles')->insert(array('id'=>'3', 'descripcion' => 'PROFESOR'));  
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('roles');
    }
}
