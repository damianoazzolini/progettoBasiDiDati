<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableNotifica extends Migration {
    public function up() {
        Schema::create('notifica',function (Blueprint $table) {
            $table->increments('notificaID');
            $table->timestamps();
            $table->integer('utenteID')->unsigned();
            $table->foreign('utenteID')->references('utenteID')->on('utente');
            $table->string('tipo');
            $table->string('tipoID');
            $table->boolean('letta');
        });
    }

    public function down() {
        Schema::dropIfExists('notifica');
    }
}
