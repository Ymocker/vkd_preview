<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {

            $table->increments('id');
            $table->integer('currnom')->unsigned(); // current edition
            $table->integer('newnom')->unsigned();  // new/next edition
            $table->integer('kolvo')->unsigned();   // number editions in archive
            $table->char('ksdelimiter', 1);
            $table->integer('smallpic')->unsigned();   // size of preview picture
            $table->string('actia', 255)->nullable();
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
        Schema::drop('settings');
    }
}
