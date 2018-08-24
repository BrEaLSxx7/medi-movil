<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQualificationsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('qualifications', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_medico')->unsigned();
            $table->integer('id_cita')->unsigned();
            $table->integer('id_paciente')->unsigned();
            $table->string('observacion', 200);
            $table->float('calificacion');
            $table->timestamps();

            $table->foreign('id_medico')->references('id')->on('medics')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('id_cita')->references('id')->on('dates')->onDelete('no action')->onUpdate('no action');
            $table->foreign('id_paciente')->references('id')->on('patients')->onDelete('no action')->onUpdate('no action');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('qualifications');
    }

}
