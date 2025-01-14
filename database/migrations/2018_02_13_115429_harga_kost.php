<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class HargaKost extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('harga_kost', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('hari');
            $table->integer('minggu');
            $table->integer('bulan');
            $table->integer('kost_id')->unsigned();
            $table->foreign('kost_id')->references('id')->on('kosts')->onDelete('cascade');
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
        //
    }
}
