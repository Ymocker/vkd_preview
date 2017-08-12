<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReklamaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reklama', function (Blueprint $table) {
            
            $table->increments('id')->unsigned();
            $table->string('rekname', 40);
            $table->integer('nomer_id')->unsigned();
            $table->tinyInteger('polosa')->unsigned();
            $table->string('web', 100)->nullable();
            $table->string('dopinf')->nullable();
            $table->timestamps();
            
            /**
             * Add Foreign/Unique/Index
             */
            $table->foreign('nomer_id')
                ->references('id')
                ->on('nomer')
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
        Schema::drop('reklama');
    }
}
