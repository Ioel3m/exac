<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsuariosHabilitadosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('usuarios_habilitados', function (Blueprint $table) {
            $table->increments('id');
            $table->string('num_identificacion', 12)->unique();
            $table->boolean('condicion')->default(1);
            $table->timestamps();
        });

        DB::table('usuarios_habilitados')->insert(array('id' => '1', 'num_identificacion' => '1207118470', 'condicion' => true));   
        DB::table('usuarios_habilitados')->insert(array('id' => '2', 'num_identificacion' => '1201215621', 'condicion' => true));   
        DB::table('usuarios_habilitados')->insert(array('id' => '3', 'num_identificacion' => '1200192831', 'condicion' => true));   
        DB::table('usuarios_habilitados')->insert(array('id' => '4', 'num_identificacion' => '1204392032', 'condicion' => true));   
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('usuarios_habilitados');
    }
}
