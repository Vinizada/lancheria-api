<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMetodosPagamentoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('metodos_pagamento', function (Blueprint $table) {
            $table->id();
            $table->string('metodo');
            $table->decimal('limite_metodo', 10, 2)->nullable()->default(0.00);
            $table->integer('ativo');
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
        Schema::dropIfExists('metodos_pagamento');
    }
}
