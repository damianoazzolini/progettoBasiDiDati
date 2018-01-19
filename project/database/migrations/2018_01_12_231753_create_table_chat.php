<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableChat extends Migration {
    public function up() {
        Schema::create('chat', function (Blueprint $table) {
            $table->increments('chatID');
            $table->timestamps();
            $table->string('chatIdentifier');
            $table->integer('senderID')->unsigned();
            $table->foreign('senderID')->references('utenteID')->on('utente');
            $table->integer('receiverID')->unsigned();
            $table->foreign('receiverID')->references('utenteID')->on('utente');
            $table->string('text');
            $table->boolean('isNew');
        });
    }
    
    public function down() {
        Schema::dropIfExists('chat');
    }
}
