<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAreasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('areas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 100);
        });

        DB::table('areas')->insert(array('id'=>'1', 'name' => 'NINGUNA'));   
        DB::table('areas')->insert(array('id'=>'2', 'name' => 'GENERAL'));   
        DB::table('areas')->insert(array('id'=>'3', 'name' => 'MATEMÁTICA'));   
        DB::table('areas')->insert(array('id'=>'4', 'name' => 'LINGUÍSTICO'));   
        DB::table('areas')->insert(array('id'=>'5', 'name' => 'CIENTÍFICO'));   
        DB::table('areas')->insert(array('id'=>'6', 'name' => 'SOCIAL'));   
        DB::table('areas')->insert(array('id'=>'7', 'name' => 'APTITUD ABSTRACTA'));   
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('areas');
    }   
}
