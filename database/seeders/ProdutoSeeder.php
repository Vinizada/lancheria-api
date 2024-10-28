<?php

namespace Database\Seeders;

use App\Models\Produto;
use App\Repositories\Contracts\AcessoRepository;
use Illuminate\Database\Seeder;

class ProdutoSeeder extends Seeder
{
    /**
     * @var array[]
     */
    private $produtos = [
            [
                'nome' => 'Coca-cola',
                'preco_venda' => 6,
                'preco_custo' => 4,
                'fornecedor_id' => 1,
                'estoque_minimo' => 10,
                'vende_sem_estoque' => true,
                'categoria_id' => 1, // Bebidas
                'ativo' => 1,
            ],
            [
                'nome' => 'Suco de Laranja Natural',
                'preco_venda' => 5,
                'preco_custo' => 2.5,
                'fornecedor_id' => 1,
                'estoque_minimo' => 5,
                'vende_sem_estoque' => true,
                'categoria_id' => 1, // Bebidas
                'ativo' => 1,
            ],
            [
                'nome' => 'Chá Gelado de Limão',
                'preco_venda' => 4,
                'preco_custo' => 1.8,
                'fornecedor_id' => 2,
                'estoque_minimo' => 8,
                'vende_sem_estoque' => true,
                'categoria_id' => 7, // Chás
                'ativo' => 1,
            ],

            // Fritos
            [
                'nome' => 'Batata Frita',
                'preco_venda' => 7,
                'preco_custo' => 3,
                'fornecedor_id' => 3,
                'estoque_minimo' => 5,
                'vende_sem_estoque' => false,
                'categoria_id' => 2, // Fritos
                'ativo' => 1,
            ],
            [
                'nome' => 'Coxinha de Frango',
                'preco_venda' => 4,
                'preco_custo' => 1.5,
                'fornecedor_id' => 2,
                'estoque_minimo' => 10,
                'vende_sem_estoque' => false,
                'categoria_id' => 2, // Fritos
                'ativo' => 1,
            ],

            // Cafés
            [
                'nome' => 'Café Expresso',
                'preco_venda' => 3,
                'preco_custo' => 1,
                'fornecedor_id' => 4,
                'estoque_minimo' => 20,
                'vende_sem_estoque' => true,
                'categoria_id' => 3, // Cafés
                'ativo' => 1,
            ],
            [
                'nome' => 'Cappuccino',
                'preco_venda' => 5,
                'preco_custo' => 2,
                'fornecedor_id' => 4,
                'estoque_minimo' => 10,
                'vende_sem_estoque' => true,
                'categoria_id' => 3, // Cafés
                'ativo' => 1,
            ],

            // Salgados
            [
                'nome' => 'Empada de Frango',
                'preco_venda' => 6,
                'preco_custo' => 2.5,
                'fornecedor_id' => 5,
                'estoque_minimo' => 5,
                'vende_sem_estoque' => false,
                'categoria_id' => 4, // Salgados
                'ativo' => 1,
            ],
            [
                'nome' => 'Esfirra de Carne',
                'preco_venda' => 4.5,
                'preco_custo' => 2,
                'fornecedor_id' => 5,
                'estoque_minimo' => 10,
                'vende_sem_estoque' => false,
                'categoria_id' => 4, // Salgados
                'ativo' => 1,
            ],

            // Doces
            [
                'nome' => 'Brigadeiro',
                'preco_venda' => 2,
                'preco_custo' => 0.8,
                'fornecedor_id' => 6,
                'estoque_minimo' => 20,
                'vende_sem_estoque' => true,
                'categoria_id' => 5, // Doces
                'ativo' => 1,
            ],
            [
                'nome' => 'Bolo de Chocolate',
                'preco_venda' => 8,
                'preco_custo' => 4,
                'fornecedor_id' => 6,
                'estoque_minimo' => 5,
                'vende_sem_estoque' => true,
                'categoria_id' => 5, // Doces
                'ativo' => 1,
            ],

            // Chocolates
            [
                'nome' => 'Chocolate Kinder Bueno',
                'preco_venda' => 6,
                'preco_custo' => 4.5,
                'fornecedor_id' => 6,
                'estoque_minimo' => 10,
                'vende_sem_estoque' => true,
                'categoria_id' => 6, // Chocolates
                'ativo' => 1,
            ],
            [
                'nome' => 'Barra de Chocolate Ao Leite',
                'preco_venda' => 4,
                'preco_custo' => 2.5,
                'fornecedor_id' => 6,
                'estoque_minimo' => 15,
                'vende_sem_estoque' => true,
                'categoria_id' => 6, // Chocolates
                'ativo' => 1,
            ],

            // Chás
            [
                'nome' => 'Chá de Camomila',
                'preco_venda' => 3,
                'preco_custo' => 1,
                'fornecedor_id' => 4,
                'estoque_minimo' => 10,
                'vende_sem_estoque' => true,
                'categoria_id' => 7, // Chás
                'ativo' => 1,
            ],
            [
                'nome' => 'Chá Verde',
                'preco_venda' => 4,
                'preco_custo' => 1.5,
                'fornecedor_id' => 4,
                'estoque_minimo' => 8,
                'vende_sem_estoque' => true,
                'categoria_id' => 7, // Chás
                'ativo' => 1,
            ],
        ];

    /**
     * @var AcessoRepository
     */
    private $acessoRepository;

    /**
     * AcessoSeeder constructor.
     * @param AcessoRepository $acessoRepository
     */
    public function __construct(AcessoRepository $acessoRepository)
    {
        $this->acessoRepository = $acessoRepository;
    }

    /**
     * @return void
     */
    public function run()
    {
        $model = app(Produto::class);

        if ($this->acessoRepository->exists($model)) return;

        foreach ($this->produtos as $data) {
            $this->acessoRepository->create($model, $data);
        }
    }
}
