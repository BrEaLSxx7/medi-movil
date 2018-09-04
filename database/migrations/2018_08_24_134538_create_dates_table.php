<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDatesTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('dates', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_medico')->unsigned();
            $table->integer('id_paciente')->unsigned();
            $table->integer('estado')->unsigned();
            $table->timeStamp('fecha');
            $table->integer('id_hora')->unsigned();
            $table->timestamps();

            $table->foreign('id_paciente')->references('id')->on('patients')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('id_medico')->references('id')->on('medics')->onDelete('no action')->onUpdate('no action');
            $table->foreign('estado')->references('id')->on('States')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('id_hora')->references('id')->on('hours')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('dates');
    }

}
