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
            $table->integer('produto_id');
            $table->integer('pedido_id');
            $table->integer('cliente_id');
            $table->integer('quantidade');
            $table->decimal('valor_total', 10, 2);
            $table->timestamp('data_movimentacao');
            $table->string('tipo_movimentacao', 1);
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
