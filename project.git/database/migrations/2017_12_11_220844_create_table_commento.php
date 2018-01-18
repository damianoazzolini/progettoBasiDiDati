<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableCommento extends Migration {
    public function up() {
        Schema::create('commento',function (Blueprint $table) {
            $table->increments('commentoID');
            $table->timestamps();
            $table->integer('utenteID')->unsigned();
            $table->foreign('utenteID')->references('utenteID')->on('utente');
            $table->integer('postID')->unsigned();
            $table->foreign('postID')->references('postID')->on('post');
            $table->text('contenuto');
            $table->boolean('attivo'); //0 non attivo, 1 attivo          
        });
    }

    public function down() {
        Schema::dropIfExists('commento');
    }
}
