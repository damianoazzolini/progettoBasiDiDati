<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTablePazienteFarmaco extends Migration {
    public function up() {
        Schema::create('paziente_farmaco', function (Blueprint $table) {
            $table->integer('idPaziente')->unsigned();
            $table->foreign('idPaziente')->references('id')->on('paziente')->onDelete('cascade');
            $table->integer('idFarmaco')->unsigned();
            $table->foreign('idFarmaco')->references('id')->on('farmaco')->onDelete('cascade');
            $table->timestamps();
            $table->unique(['idPaziente','idFarmaco']);            
        });
    }

    public function down() {
        Schema::dropIfExists('paziente_farmaco');
    }
}
