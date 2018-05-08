<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableFarmacoPrestazione extends Migration
{
    public function up() {
        Schema::create('farmaco_prestazione', function (Blueprint $table) {
            $table->integer('idFarmaco')->unsigned();
            $table->foreign('idFarmaco')->references('id')->on('farmaco')->onDelete('cascade');
            $table->integer('idPrestazione')->unsigned();
            $table->foreign('idPrestazione')->references('id')->on('prestazione')->onDelete('cascade');
            $table->timestamps();
            $table->unique(['idPrestazione','idFarmaco']);                        
        });
    }

    public function down() {
        Schema::dropIfExists('farmaco_prestazione');
    }
}
