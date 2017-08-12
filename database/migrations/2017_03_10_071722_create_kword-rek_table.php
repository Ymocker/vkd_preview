<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKwordRekTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kword_reklama', function (Blueprint $table) {

            $table->increments('id')->unsigned();
            $table->integer('reklama_id')->unsigned();
            $table->integer('kword_id')->unsigned();
            
            /**
             * Add Foreign/Unique/Index
             */
            $table->foreign('kword_id')
                ->references('id')
                ->on('kwords')
                ->onDelete('cascade');

            $table->foreign('reklama_id')
                ->references('id')
                ->on('reklama')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('kword_reklama');
    }
}
