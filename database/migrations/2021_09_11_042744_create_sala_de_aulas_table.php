<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalaDeAulasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sala_de_aulas', function (Blueprint $table) {
            $table->id('idSalaDeAula');
            $table->string('nome', 200);
            $table->integer('idDiario');
            $table->integer('periodo');
            $table->integer('ano');
            $table->dateTime('dataCriacao')->useCurrent();
            $table->unsignedBigInteger('idProfessor');
            $table->foreign('idProfessor')->references('idProfessor')->on('professors');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sala_de_aulas');
    }
}
