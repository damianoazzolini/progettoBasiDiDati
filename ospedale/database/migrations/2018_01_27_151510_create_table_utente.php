<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableUtente extends Migration {
    public function up() {
        Schema::create('utente', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nome');
            $table->string('cognome');
            $table->date('dataNascita');
            $table->boolean('sesso');
            $table->string('codiceFiscale')->unique();
            $table->string('email')->unique();
            $table->string('password');
            $table->string('telefono');
            $table->boolean('attivo');
            $table->string('provincia');
            $table->string('stato');
            $table->string('comune');
            $table->string('via');
            $table->integer('numeroCivico');
            $table->timestamps();
        });
    }

    public function down() {
        Schema::dropIfExists('utente');
    }
}
