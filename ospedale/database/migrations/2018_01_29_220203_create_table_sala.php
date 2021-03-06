<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableSala extends Migration {
    public function up() {
        Schema::create('sala', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nome');
            $table->integer('idReparto')->unsigned();
            $table->foreign('idReparto')->references('id')->on('reparto')->onDelete('cascade');
            $table->text('descrizione')->nullable();
            $table->integer('piano');
            $table->timestamps();
            $table->unique(['nome','idReparto']);
        });
    }

    public function down() {
        Schema::dropIfExists('sala');
    }
}
