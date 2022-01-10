<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLikesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('likes', function (Blueprint $table) {
            $table->id('idLike');
            $table->dateTime('data')->useCurrent();
            $table->string('matricula', 20);
            $table->foreign('matricula')->references('matricula')->on('usuarios');
            $table->unsignedBigInteger('idPergunta');
            $table->foreign('idPergunta')->references('idPergunta')->on('perguntas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('likes');
    }
}
