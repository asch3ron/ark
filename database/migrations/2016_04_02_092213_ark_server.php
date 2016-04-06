<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ArkServer extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ark_server', function (Blueprint $table) {
            $table->increments('id_server');
            $table->string('name', 128);
            $table->string('ip', 64);
            $table->string('path', 256);
            $table->integer('port')->unsigned();
            $table->timestamps();
        });

        Schema::create('ark_server_configuration', function (Blueprint $table) {
            $table->unsignedInteger('id_server');
            $table->unsignedInteger('id_configuration');
            $table->primary(['id_server', 'id_configuration']);
            $table->string('value', 512);
            $table->timestamps();
            $table->foreign('id_server')->references('id_server')->on('ark_server');
            $table->foreign('id_configuration')->references('id')->on('ark_configurations');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('ark_server');
        Schema::drop('ark_server_configuration');
    }
}
