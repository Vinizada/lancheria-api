<?php

namespace App\Services;

use App\Constants\TipoMovimentacao;
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
            $entradas = $this->buscaMovimentacoes($produto, TipoMovimentacao::ENTRADA);
            $saidas = $this->buscaMovimentacoes($produto, TipoMovimentacao::SAIDA);

            $estoqueAtual = $entradas->sum('quantidade') - $saidas->sum('quantidade');
            $valorAtual   = $estoqueAtual * $produto->preco_venda;

            $dadosAlterados = [
                'quantidade'          => $estoqueAtual,
                'valor_estoque_atual' => $valorAtual,
            ];

            $this->estoqueRepository->updateEstoque($produto->id, $dadosAlterados);

            event(new CadastroCompra());

        } catch (\Exception $exception) {
            throw new Exception('Falha ao atualizar estoque!' . $exception->getMessage());
        }
    }

    public function getMovimentacoesProduto(Produto $produto)
    {
        return $this->movimentacaoEstoqueRepository->buscaMovimentacoesProduto($produto, TipoMovimentacao::ENTRADA);
    }

    /**
     * @param Produto $produto
     * @param $tipoMovimentacao
     * @return mixed
     */
    private function buscaMovimentacoes(Produto $produto, $tipoMovimentacao)
    {
        return $this->movimentacaoEstoqueRepository->buscaMovimentacoesProduto($produto, $tipoMovimentacao);
    }
}
