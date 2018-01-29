<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableQualifica extends Migration {
    public function up() {
        Schema::create('qualifica', function (Blueprint $table) {
            $table->increments('id');
            $table->text('descrizione')->nullable();
            $table->string('nome');
            $table->timestamps();
        });
    }

    public function down() {
        Schema::dropIfExists('qualifica');
    }
}
