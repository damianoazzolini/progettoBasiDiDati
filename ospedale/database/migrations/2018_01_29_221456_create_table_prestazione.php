<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTablePrestazione extends Migration {
    public function up() {
        Schema::create('prestazione', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('idReparto')->unsigned();
            $table->foreign('idReparto')->references('id')->on('reparto')->onDelete('cascade');
            $table->integer('idPaziente')->unsigned();
            $table->foreign('idPaziente')->references('id')->on('paziente')->onDelete('cascade');
            $table->integer('idSala')->unsigned();
            $table->foreign('idSala')->references('id')->on('sala')->onDelete('cascade');
            $table->string('identificativo');
            $table->text('note')->nullable();
            $table->boolean('attivo');
            $table->boolean('effettuata');
            $table->date('data');
            $table->time('ora');
            $table->integer('durata');
            $table->timestamps();
        });
    }

    public function down() {
        Schema::dropIfExists('prestazione');
    }
}
