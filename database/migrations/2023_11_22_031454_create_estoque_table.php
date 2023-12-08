<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEstoqueTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('estoque', function (Blueprint $table) {
            $table->unsignedBigInteger('produto_id')->unique();
            $table->integer('quantidade');
            $table->timestamp('data_validade')->nullable();
            $table->decimal('valor_estoque_atual', 10, 2)->nullable();
            $table->decimal('valor_custo_unitario', 10, 2);
            $table->timestamp('data_criacao');
            $table->timestamp('data_alteracao');

            $table->primary('produto_id');

            $table->foreign('produto_id')->references('id')->on('produtos')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('estoque');
    }
}
