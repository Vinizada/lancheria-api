<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePedidosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pedidos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('cliente_id');
            $table->unsignedBigInteger('metodo_id');
            $table->decimal('valor_total', 10, 2);
            $table->string('status', 1);
            $table->integer('quantidade_itens');
            $table->timestamp('data');
            $table->unsignedBigInteger('colaborador_id');
            $table->integer('cancelado')->default(0)->nullable();
            $table->timestamp('data_cancelamento')->nullable();

            $table->foreign('cliente_id')->references('id')->on('clientes');
            $table->foreign('metodo_id')->references('id')->on('metodos_pagamento');
            $table->foreign('colaborador_id')->references('id')->on('colaboradores'); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pedidos');
    }
}
