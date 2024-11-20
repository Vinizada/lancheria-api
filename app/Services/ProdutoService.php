<?php

namespace App\Services;

use App\Models\Produto;
use App\Repositories\Contracts\EstoqueRepository;
use App\Repositories\Contracts\MovimentacaoEstoqueRepository;
use Exception;
use Illuminate\Support\Collection;

class ProdutoService
{
    public function __construct(MovimentacaoEstoqueRepository $movimentacaoEstoqueRepository, EstoqueRepository $estoqueRepository)
    {
        $this->estoqueRepository = $estoqueRepository;
        $this->movimentacaoEstoqueRepository = $movimentacaoEstoqueRepository;
    }

    public function processaProdutos($produtos)
    {
        $produtosProcessados = collect();
        $produtos = json_decode($produtos);

        foreach ($produtos as $produtoId => $produto) {
            $produtosProcessados->push([
                'produto_id' => $produtoId,
                'quantidade' => $produto->quantidade,
                'preco' => $produto->preco,
            ]);
        }

        return $produtosProcessados;
    }
}
