<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUtenteRoleTable extends Migration {

    public function up() {
        Schema::create('utente_role', function (Blueprint $table) {
            $table->integer('user_id')->references('id')->on('utente');
            $table->integer('role_id')->references('id')->on('role');
            $table->timestamps();
            $table->unique(['user_id','role_id']);
        });
    }

    public function down() {
        Schema::dropIfExists('utente_role');
    }
}
