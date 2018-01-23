<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTablePagina extends Migration {
    public function up() {
        Schema::create('pagina',function (Blueprint $table) {
            $table->increments('paginaID');
            $table->timestamps();
            $table->string('nome')->unique();
            $table->boolean('attivo');
            $table->string('immagine'); 
            $table->text('descrizione'); 
            $table->string('tipo');
        });
    }

    public function down() {
        Schema::dropIfExists('pagina');
    }
}
