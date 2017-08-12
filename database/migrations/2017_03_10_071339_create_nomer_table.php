<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNomerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nomer', function (Blueprint $table) {
            
            $table->increments('id')->unsigned();
            $table->integer('nomgaz')->unsigned();
            $table->integer('nomgod')->unsigned();
            $table->string('datavyh', 40);
            //$table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('nomer');
    }
}
