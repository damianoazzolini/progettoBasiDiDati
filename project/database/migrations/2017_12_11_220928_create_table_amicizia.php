<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableAmicizia extends Migration {
    public function up() {
        Schema::create('amicizia',function (Blueprint $table) {
            $table->timestamps();
            $table->integer('utenteID1')->unsigned();
            $table->foreign('utenteID1')->references('utenteID')->on('utente');
            $table->integer('utenteID2')->unsigned();
            $table->foreign('utenteID2')->references('utenteID')->on('utente');
            $table->string('stato');
        });
    }

    public function down() {
        Schema::dropIfExists('amicizia');
    }
}
