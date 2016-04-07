<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ServerLog extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ark_server_log', function (Blueprint $table) {
            $table->increments('id_log');
            $table->longText('message');
            $table->unsignedInteger('id_server');
            $table->foreign('id_server')->references('id_server')->on('ark_server');
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
        Schema::drop('ark_server_log');
    }
}
