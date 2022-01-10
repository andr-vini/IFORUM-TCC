<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemUsuariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('item_usuarios', function (Blueprint $table) {
            $table->id('idItemUsuario');
            $table->tinyInteger('equipado');
            $table->dateTime('dataCompra')->useCurrent();
            $table->unsignedBigInteger('idItem');
            $table->foreign('idItem')->references('idItem')->on('items');
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
        Schema::dropIfExists('item_usuarios');
    }
}
