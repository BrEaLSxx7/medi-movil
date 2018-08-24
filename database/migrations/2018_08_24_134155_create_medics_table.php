<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMedicsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('medics', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre', 100);
            $table->integer('tipo_documento')->unsigned();
            $table->string('numero_documento', 30)->unique();
            $table->string('telefono', 30);
            $table->string('correo', 50);
            $table->string('foto', 50);
            $table->float('precio');
            $table->string('descripcion', 200);
            $table->float('calificacion');
            $table->timestamps();

            $table->foreign('tipo_documento')->references('id')->on('document_types')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('medics');
    }
}
