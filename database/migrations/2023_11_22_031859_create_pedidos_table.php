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
            $table->integer('cliente_id');
            $table->integer('metodo_id');
            $table->decimal('valor_total', 10, 2);
            $table->string('status', 1);
            $table->integer('quantidade_itens');
            $table->timestamp('data');
            $table->integer('colaborador_id');
            $table->integer('cancelado')->default(0);
            $table->timestamp('data_cancelamento');
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
