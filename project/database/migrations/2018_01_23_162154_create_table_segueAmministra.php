<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableSegueAmministra extends Migration {
    public function up() {
        Schema::create('segueAmministra',function (Blueprint $table) {
            $table->timestamps();
            $table->integer('utenteID')->unsigned();
            $table->foreign('utenteID')->references('utenteID')->on('utente');
            $table->integer('paginaID')->unsigned();
            $table->foreign('paginaID')->references('paginaID')->on('pagina');
            $table->string('stato');
        });
    }

    public function down() {
        Schema::dropIfExists('segueAmministra');
    }
}
