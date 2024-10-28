<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContaClienteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('conta_cliente', function (Blueprint $table) {
            $table->id();
            $table->integer('cliente_id');
            $table->integer('pedido_id');
            $table->decimal('valor', 10, 2);
            $table->string('tipo_operacao');
            $table->decimal('valor_disponivel');
            $table->timestamp('data_criacao');
            $table->timestamp('data_alteracao');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('conta_cliente');
    }
}
