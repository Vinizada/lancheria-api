<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMovimentacaoEstoqueTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('movimentacao_estoque', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('produto_id');
            $table->unsignedBigInteger('pedido_id')->nullable();
            $table->unsignedBigInteger('cliente_id')->nullable();
            $table->unsignedBigInteger('colaborador_id');
            $table->integer('quantidade');
            $table->decimal('valor_total', 10, 2);
            $table->decimal('valor_unitario', 10, 2);
            $table->timestamp('data_movimentacao');
            $table->string('tipo_movimentacao', 1);

            $table->foreign('cliente_id')->references('id')->on('clientes');
            $table->foreign('pedido_id')->references('id')->on('pedidos');
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
        Schema::dropIfExists('movimentacao_estoque');
    }
}
