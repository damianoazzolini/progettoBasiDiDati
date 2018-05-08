<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableStaff extends Migration {
    public function up() {
        Schema::create('staff', function (Blueprint $table) {
            $table->integer('id')->unsigned();
            $table->foreign('id')->references('id')->on('utente')->onDelete('cascade');
            $table->integer('idReparto')->unsigned();
            $table->foreign('idReparto')->references('id')->on('reparto')->onDelete('cascade');
            $table->string('identificativo')->unique;
            $table->integer('stipendio')->nullable();
            $table->timestamps();
        });
    }

    public function down() {
        Schema::dropIfExists('staff');
    }
}
