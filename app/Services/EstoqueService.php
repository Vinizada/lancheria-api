<?php

namespace App\Services;

use App\Events\CadastroCompra;
use App\Models\MovimentacaoEstoque;
use App\Models\Produto;
use App\Repositories\Contracts\EstoqueRepository;
use App\Repositories\Contracts\MovimentacaoEstoqueRepository;
use Exception;

class EstoqueService
{

    /** @var MovimentacaoEstoqueRepository */
    private $movimentacaoEstoqueRepository;

    /** @var EstoqueRepository */
    private $estoqueRepository;

    public function __construct(MovimentacaoEstoqueRepository $movimentacaoEstoqueRepository, EstoqueRepository $estoqueRepository)
    {
        $this->estoqueRepository             = $estoqueRepository;
        $this->movimentacaoEstoqueRepository = $movimentacaoEstoqueRepository;
    }

    public function atualizaEstoque(Produto $produto)
    {
        try {
            $movimentacoes = $this->buscaMovimentacoes($produto);

            $entradas = $movimentacoes->filter(function (MovimentacaoEstoque $movimentacao) {
                return $movimentacao->isEntrada();
            })->sum('quantidade');

            $saidas = $movimentacoes->filter(function (MovimentacaoEstoque $movimentacao) {
                return $movimentacao->isSaida();
            })->sum('quantidade');

            $estoqueAtual = $entradas - $saidas;
            $valorAtual   = $estoqueAtual * $produto->preco_venda;

            $dadosAlterados = [
                'quantidade'          => $estoqueAtual,
                'valor_estoque_atual' => $valorAtual,
            ];

            $this->estoqueRepository->updateEstoque($produto->id, $dadosAlterados);

        } catch (\Exception $exception) {
            throw new Exception('Falha ao atualizar estoque!' . $exception->getMessage());
        }
    }

    /**
     * @param Produto $produto
     * @return mixed
     */
    private function buscaMovimentacoes(Produto $produto)
    {
        return $this->movimentacaoEstoqueRepository->buscaMovimentacoesProduto($produto);
    }
}
