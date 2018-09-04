<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAuthenticationsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('authentications', function (Blueprint $table) {
            $table->increments('id');
            $table->string('usuario', 50)->unique();
            $table->string('contrasena', 60);
            $table->integer('id_paciente')->unsigned()->nullable();
            $table->integer('id_rol')->unsigned();
            $table->integer('id_medico')->unsigned()->nullable();
            $table->timestamps();

            $table->foreign('id_paciente')->references('id')->on('patients')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('id_rol')->references('id')->on('roles')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('id_medico')->references('id')->on('medics')->onDelete('no action')->onUpdate('no action');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('authentications');
    }

}
