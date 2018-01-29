<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTablePrestazione extends Migration {
    public function up() {
        Schema::create('prestazione', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('idReparto')->unsigned();
            $table->foreign('idReparto')->references('id')->on('reparto');
            $table->string('identificativo');
            $table->text('note')->nullable();
            $table->boolean('attivo');
            $table->boolean('effettuata');
            $table->timestamps();
        });
    }

    public function down() {
        Schema::dropIfExists('prestazione');
    }
}
