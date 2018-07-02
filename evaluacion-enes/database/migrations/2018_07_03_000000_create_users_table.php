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
            $table->string('nombres');
            $table->string('apellidos');
            $table->string('nickname')->unique();
            $table->string('email')->unique();
            $table->string('password');
            $table->string('telefono');
            $table->string('direccion');           
            $table->date('fecha_nacimiento');           
            $table->string('estado_civil');
            $table->boolean('condicion')->default(1);
            
            $table->integer('idrol')->unsigned();
            $table->foreign('idrol')->references('id')->on('roles');

            $table->integer('idusuario_habilitado')->unsigned();
            $table->foreign('idusuario_habilitado')->references('id')->on('usuarios_habilitados')->onDelete('cascade');

            $table->integer('idparalelo')->unsigned();
            $table->foreign('idparalelo')->references('id')->on('paralelos')->onDelete('cascade');

            $table->rememberToken();
            $table->timestamps();
        });

        DB::table('users')->insert(array('id'=>'1', 'nombres' => '', 'apellidos' => '', 'nickname' => '1207118470-ADM', 'email' => 'jdiazm470@utb.edu.ec','password' => Hash::make('1207118470'), 'telefono' => '', 'direccion' => '', 'fecha_nacimiento' => '1994-10-31', 'estado_civil' => 'SOLTERO', 'idrol' => '1', 'idusuario_habilitado' => '1', 'idparalelo' => '1'));  
        DB::table('users')->insert(array('id'=>'2', 'nombres' => 'JONNHY', 'apellidos' => 'ARBOLEDA', 'nickname' => '1201215621-DOC', 'email' => '1201215621-DOC', 'password' => Hash::make('1201215621'), 'telefono' => '', 'direccion' => '', 'fecha_nacimiento' => '1990-03-18', 'estado_civil' => '', 'idrol' => '3', 'idusuario_habilitado' => '2', 'idparalelo' => '2'));  
       
        DB::table('users')->insert(array('id'=>'3', 'nombres' => '', 'apellidos' => '', 'nickname' => '1200192831-EST', 'email' => '1200192831-EST', 'password' => Hash::make('1200192831'), 'telefono' => '', 'direccion' => '', 'fecha_nacimiento' => '2018-07-02', 'estado_civil' => '', 'idrol' => '2', 'idusuario_habilitado' => '3', 'idparalelo' => '2'));  
        DB::table('users')->insert(array('id'=>'4', 'nombres' => '', 'apellidos' => '', 'nickname' => '1204392032-EST', 'email' => '1204392032-EST', 'password' => Hash::make('1204392032'), 'telefono' => '', 'direccion' => '', 'fecha_nacimiento' => '2018-07-02', 'estado_civil' => '', 'idrol' => '2', 'idusuario_habilitado' => '4', 'idparalelo' => '2'));          
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
