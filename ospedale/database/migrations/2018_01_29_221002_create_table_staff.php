<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableStaff extends Migration {
    public function up() {
        Schema::create('staff', function (Blueprint $table) {
            $table->integer('id')->unsigned();
            $table->foreign('id')->references('id')->on('utente');
            $table->integer('idReparto')->unsigned();
            $table->foreign('idReparto')->references('id')->on('reparto');
            $table->string('identificativo');
            $table->integer('stipendio')->nullable();
            $table->timestamps();
        });
    }

    public function down() {
        Schema::dropIfExists('staff');
    }
}
