<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(AcessoSeeder::class);
        $this->call(PerfilSeeder::class);
        $this->call(ColaboradorSeeder::class);
        $this->call(PerfilAcessosSeeder::class);
        $this->call(MetodoPagamentoSeeder::class);
        $this->call(CategoriaSeeder::class);
        $this->call(ClienteSeeder::class);
        $this->call(ProdutoSeeder::class);
    }
}
