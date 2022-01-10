<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRespostasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('respostas', function (Blueprint $table) {
            $table->id('idResposta');
            $table->text('texto');
            $table->integer('nota')->nullable();
            $table->dateTime('data')->useCurrent();
            $table->unsignedBigInteger('idPergunta');
            $table->foreign('idPergunta')->references('idPergunta')->on('perguntas');
            $table->string('matricula', 20);
            $table->foreign('matricula')->references('matricula')->on('usuarios');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('respostas');
    }
}
