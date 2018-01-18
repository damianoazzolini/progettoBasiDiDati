<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableMedia extends Migration {
    public function up() {
        Schema::create('media',function (Blueprint $table) {
            $table->increments('mediaID');
            $table->timestamps();
            $table->integer('postID')->unsigned();
            $table->foreign('postID')->references('postID')->on('post');
            $table->text('percorso');
        });
    }

    public function down() {
        Schema::dropIfExists('media');
    }
}
