<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableReparto extends Migration {
    public function up() {
        Schema::create('reparto', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nome')->unique();
            $table->string('identificativo')->unique();
            $table->text('descrizione')->nullable();            
            $table->timestamps();
        });
    }

    public function down() {
        Schema::dropIfExists('reparto');
    }
}
