<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePerfilTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('perfil', function (Blueprint $table) {
            $table->id();
            $table->string('perfil', 50);
            $table->unsignedBigInteger('acesso_id');
            $table->integer('ativo');
            $table->timestamp('data_criacao');
            $table->timestamp('data_alteracao');

            $table->foreign('acesso_id')->references('id')->on('acessos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('perfil');
    }
}
