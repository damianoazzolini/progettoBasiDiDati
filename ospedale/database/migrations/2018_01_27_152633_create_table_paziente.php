<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTablePaziente extends Migration {
    public function up() {
        Schema::create('paziente', function (Blueprint $table) {
            $table->integer('id')->unsigned();
            $table->foreign('id')->references('id')->on('utente')->onDelete('cascade');
            $table->text('note')->nullable();
            $table->integer('altezza');
            $table->integer('peso');
            $table->timestamps();
        });
    }

    public function down() {
        Schema::dropIfExists('paziente');
    }
}
