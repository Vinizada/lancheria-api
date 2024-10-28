<?php

namespace App\Jobs;

use App\Constants\TipoMovimentacao;
use App\Models\MovimentacaoEstoque;
use App\Models\Produto;
use App\Repositories\Contracts\EstoqueRepository;
use App\Repositories\Contracts\MovimentacaoEstoqueRepository;
use App\Repositories\Contracts\ProdutoRepository;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CadastroCompraJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /** @var EstoqueRepository */
    private $estoqueRepository;

    /** @var ProdutoRepository */
    private $produtoRepository;

    /** @var MovimentacaoEstoqueRepository */
    private $movimentacaoEstoqueRepository;

    /** @var Produto[] */
    private $produtos;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(EstoqueRepository             $estoqueRepository,
                                ProdutoRepository             $produtoRepository,
                                MovimentacaoEstoqueRepository $movimentacaoEstoqueRepository)
    {
        $this->estoqueRepository = $estoqueRepository;
        $this->movimentacaoEstoqueRepository = $movimentacaoEstoqueRepository;
        $this->produtoRepository = $produtoRepository;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->produtos = $this->produtoRepository->getProdutos();

        /** @var Produto $produto */
        foreach ($this->produtos as $produto) {

            $update = [
                'preco_medio' => $this->calculaValorMedio($produto),
                'preco_custo' => $this->buscaUltimoValorCompra($produto),
            ];

            $this->produtoRepository->updateProduto($produto->id, $update);
        }
    }

    /**
     * @param Produto $produto
     * @return float
     */
    private function calculaValorMedio(Produto $produto): float
    {
        $movimentacoesEntrada = $this->movimentacaoEstoqueRepository->buscaMovimentacoesProduto(
            $produto,
            TipoMovimentacao::ENTRADA);

        if ($movimentacoesEntrada->count() > 0) {
            $quantidadeMovimentacoes = $movimentacoesEntrada->count();
            $somaValorUnitario = 0;
            foreach ($movimentacoesEntrada as $movimentacao) {
                $somaValorUnitario = $movimentacao['valor_unitario'];
            }
            return round(($somaValorUnitario / $quantidadeMovimentacoes),2);
        }

        return 0;
    }

    /**
     * @param Produto $produto
     * @return float
     */
    private function buscaUltimoValorCompra(Produto $produto): float
    {
        return $this->movimentacaoEstoqueRepository->buscaUltimaMovimentacaoProduto($produto, TipoMovimentacao::ENTRADA) ?? 0;
    }
}
