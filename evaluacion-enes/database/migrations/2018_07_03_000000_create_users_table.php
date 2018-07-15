<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
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
            $table->string('nombres')->nullable();
            $table->string('apellidos')->nullable();
            $table->string('cedula')->unique();
            $table->string('nickname')->unique();
            $table->string('email')->nullable();
            $table->string('password');
            $table->string('telefono')->nullable();
            $table->string('direccion')->nullable();           
            $table->date('fecha_nacimiento')->nullable();           
            $table->string('estado_civil')->nullable();
            $table->boolean('informacion_personal');
            $table->boolean('condicion')->default(1);
            
            $table->integer('idrol')->unsigned();
            $table->foreign('idrol')->references('id')->on('roles')->onDelete('cascade')->onUpdate('cascade');

            $table->integer('idparalelo')->unsigned();
            $table->foreign('idparalelo')->references('id')->on('paralelos')->onDelete('cascade')->onUpdate('cascade');

            $table->integer('idarea')->unsigned();
            $table->foreign('idarea')->references('id')->on('areas')->onDelete('cascade')->onUpdate('cascade');
            
            $table->integer('idperiodo')->unsigned();
            $table->foreign('idperiodo')->references('id')->on('periodos_academicos')->onDelete('cascade')->onUpdate('cascade');

            $table->rememberToken();
            $table->timestamps();
        });

        DB::table('users')->insert(array('id'=>'1', 'nombres' => '', 'apellidos' => '','cedula' => '1207118470', 'nickname' => '1207118470-ADM', 'email' => 'jdiazm470@utb.edu.ec','password' => Hash::make('1207118470'), 'telefono' => '', 'direccion' => '', 'fecha_nacimiento' => '1994-10-31', 'estado_civil' => 'SOLTERO', 'informacion_personal' => '1','idrol' => '1',  'idparalelo' => '1', 'idarea' => '1', 'idperiodo' => '1'));  
        DB::table('users')->insert(array('id'=>'2', 'nombres' => 'JONNHY', 'apellidos' => 'ARBOLEDA', 'cedula' => '1201215621', 'nickname' => '1201215621-DOC', 'email' => '', 'password' => Hash::make('1201215621'), 'telefono' => '', 'direccion' => '', 'fecha_nacimiento' => '1990-03-18', 'estado_civil' => '', 'informacion_personal' => '1', 'idrol' => '3', 'idparalelo' => '2','idarea' => '3', 'idperiodo' => '1'));  
       
        DB::table('users')->insert(array('id'=>'3', 'nombres' => '', 'apellidos' => '', 'cedula' => '1200192831', 'nickname' => '1200192831-EST', 'email' => '', 'password' => Hash::make('1200192831'), 'telefono' => '', 'direccion' => '', 'fecha_nacimiento' => '2018-07-02', 'estado_civil' => '', 'informacion_personal' => '0', 'idrol' => '2', 'idparalelo' => '2', 'idarea' => '2', 'idperiodo' => '1'));  
        DB::table('users')->insert(array('id'=>'4', 'nombres' => '', 'apellidos' => '', 'cedula' => '1204392032', 'nickname' => '1204392032-EST', 'email' => '', 'password' => Hash::make('1204392032'), 'telefono' => '', 'direccion' => '', 'fecha_nacimiento' => '2018-07-02', 'estado_civil' => '', 'informacion_personal' => '0', 'idrol' => '2', 'idparalelo' => '2', 'idarea' => '2', 'idperiodo' => '1'));          
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
