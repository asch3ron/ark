<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Changelog extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ark_changelog', function (Blueprint $table) {
            $table->increments('id_changelog');
            $table->float('version')->unsigned();
            $table->longText('text');
            $table->boolean('seen')->default(false);
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('ark_changelog');
    }
}
