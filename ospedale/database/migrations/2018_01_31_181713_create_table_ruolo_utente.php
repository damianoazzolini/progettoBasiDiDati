<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableRuoloUtente extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ruolo_utente', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->integer('ruolo_id')->unsigned()->onDelete('cascade');
            $table->integer('utente_id')->unsigned()->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ruolo_utente');
    }
}
