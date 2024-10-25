<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProdutosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('produtos', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->decimal('preco_venda', 10, 2);
            $table->decimal('preco_custo', 10, 2)->nullable();
            $table->decimal('preco_medio', 10, 2)->nullable();
            $table->unsignedBigInteger('fornecedor_id')->nullable();
            $table->integer('estoque_minimo')->nullable();
            $table->decimal('giro_medio', 10, 2)->nullable();
            $table->integer('ativo')->nullable();
            $table->boolean('vende_sem_estoque')->default(false);
            $table->integer('categoria_id');
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
        Schema::dropIfExists('produtos');
    }
}
