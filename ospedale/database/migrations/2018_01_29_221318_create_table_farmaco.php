<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableFarmaco extends Migration {
    public function up() {
        Schema::create('farmaco', function (Blueprint $table) {
            $table->increments('id');
            $table->text('descrizione');
            $table->string('nome');
            $table->string('categoria');
            $table->timestamps();
        });
    }

    public function down() {
        Schema::dropIfExists('qualifica');
    }
}
