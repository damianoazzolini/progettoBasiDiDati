<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableReferto extends Migration {
    public function up() {
        Schema::create('referto', function (Blueprint $table) {
            $table->integer('id')->unsigned();
            $table->foreign('id')->references('id')->on('prestazione')->onDelete('cascade');
            $table->integer('idPaziente')->unsigned();
            $table->foreign('idPaziente')->references('id')->on('paziente')->onDelete('cascade');
            $table->text('esito');
            $table->text('note')->nullable();
            $table->timestamps();
        });
    }

    public function down() {
        Schema::dropIfExists('referto');
    }
}
