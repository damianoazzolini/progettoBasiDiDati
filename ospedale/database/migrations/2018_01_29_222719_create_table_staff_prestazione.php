<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableStaffPrestazione extends Migration {
    public function up() {
        Schema::create('staff_prestazione', function (Blueprint $table) {
            $table->integer('idStaff')->unsigned();
            $table->foreign('idStaff')->references('id')->on('staff');
            $table->integer('idPrestazione')->unsigned();
            $table->foreign('idPrestazione')->references('id')->on('prestazione');
            $table->timestamps();
        });
    }

    public function down() {
        Schema::dropIfExists('staff_prestazione');
    }
}
