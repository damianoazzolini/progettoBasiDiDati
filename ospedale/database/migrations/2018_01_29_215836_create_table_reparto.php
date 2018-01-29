<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableReparto extends Migration {
    public function up() {
        Schema::create('reparto', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nome');
            $table->string('identificativo');
            $table->text('descrizione');            
            $table->timestamps();
        });
    }

    public function down() {
        Schema::dropIfExists('reparto');
    }
}
