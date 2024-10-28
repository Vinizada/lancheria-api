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
        $produtosProcessados = [];

        $produtos->each(function ($produto, $produtoId) use (&$produtosProcessados) {
            $produtosProcessados[] = [
                'produto_id' => $produtoId,
                'quantidade' => $produto['quantidade'],
                'preco' => $produto['preco'],
                'estoque' => $produto['estoque'],
            ];
        });

        return collect($produtosProcessados);
    }
}
