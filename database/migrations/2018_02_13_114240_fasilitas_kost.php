<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class FasilitasKost extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fasilitas_kost', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('fasilitas_id')->unsigned();
            $table->integer('kost_id')->unsigned();
            $table->foreign('kost_id')->references('id')->on('kosts')->onDelete('cascade');
            $table->foreign('fasilitas_id')->references('id')->on('fasilitas')->onDelete('cascade');
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
        Schema::table('fasilitas_kost', function (Blueprint $table) {
            //
        });
    }
}
