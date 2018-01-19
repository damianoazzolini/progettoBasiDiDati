<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTablePost extends Migration {
    public function up() {
        Schema::create('post',function (Blueprint $table) {
            $table->increments('postID');
            $table->timestamps();
            $table->integer('utenteID')->unsigned();
            $table->foreign('utenteID')->references('utenteID')->on('utente');
            $table->text('contenuto')->nullable();
            $table->boolean('attivo'); //0 non attivo, 1 attivo
        });
    }

    public function down() {
        Schema::dropIfExists('post');
    }
}
