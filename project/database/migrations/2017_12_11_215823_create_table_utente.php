<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableUtente extends Migration {
    public function up() {
        Schema::create('utente',function (Blueprint $table) {
            $table->increments('utenteID');
            $table->timestamps();
            $table->string('nome');
            $table->string('cognome');
            $table->string('email')->unique();
            $table->string('password');
            $table->boolean('attivo');
            $table->date('dataNascita');
            $table->boolean('sesso');
            $table->string('immagine'); 
            $table->string('codice'); 
            $table->text('remember_token'); #necessario per poter fare login/logout
        });
    }
    
    public function down() {
        Schema::dropIfExists('utente');
    }
}
