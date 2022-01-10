<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVinculosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vinculos', function (Blueprint $table) {
            $table->id('idVinculo');
            $table->tinyInteger('ativo');
            $table->integer('status');
            $table->dateTime('dataIngresso')->useCurrent();
            $table->unsignedBigInteger('idAluno');
            $table->foreign('idAluno')->references('idAluno')->on('alunos');
            $table->unsignedBigInteger('idSalaDeAula');
            $table->foreign('idSalaDeAula')->references('idSalaDeAula')->on('sala_de_aulas');
            $table->tinyInteger('moderadorSala')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vinculos');
    }
}
