<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableReazione extends Migration {
    public function up() {
        Schema::create('reazione',function (Blueprint $table) {
            $table->increments('reazioneID');
            $table->timestamps();
            $table->integer('utenteID')->unsigned();
            $table->foreign('utenteID')->references('utenteID')->on('utente');
            $table->integer('postID')->unsigned();
            $table->foreign('postID')->references('postID')->on('post');
            $table->boolean('flag');
        });
    }

    public function down() {
        Schema::dropIfExists('reazione');
    }
}
