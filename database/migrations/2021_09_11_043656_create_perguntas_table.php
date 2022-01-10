<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePerguntasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('perguntas', function (Blueprint $table) {
            $table->id('idPergunta');
            $table->text('texto');
            $table->tinyInteger('status')->default(0);
            $table->integer('nota')->nullable();
            $table->dateTime('data')->useCurrent();
            $table->unsignedBigInteger('idSalaDeAula');
            $table->foreign('idSalaDeAula')->references('idSalaDeAula')->on('sala_de_aulas');
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
        Schema::dropIfExists('perguntas');
    }
}
