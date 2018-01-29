<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTablePaziente extends Migration {
    public function up() {
        Schema::create('paziente', function (Blueprint $table) {
            $table->integer('id')->unsigned();
            $table->foreign('id')->references('id')->on('utente');
            $table->text('note')->nullable();
            $table->integer('altezza')->nullable();
            $table->integer('peso')->nullable();
            $table->timestamps();
        });
    }

    public function down() {
        Schema::dropIfExists('paziente');
    }
}
