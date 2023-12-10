<?php

namespace App\Listeners;

use App\Events\CadastroCompra;
use App\Jobs\CadastroCompraJob;
use App\Repositories\Contracts\EstoqueRepository;
use App\Repositories\Contracts\MovimentacaoEstoqueRepository;
use App\Repositories\Contracts\ProdutoRepository;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class CadastroCompraListener
{
    /** @var EstoqueRepository */
    private $estoqueRepository;

    /** @var ProdutoRepository */
    private $produtoRepository;

    /** @var MovimentacaoEstoqueRepository */
    private $movimentacaoEstoqueRepository;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(EstoqueRepository $estoqueRepository,
                                ProdutoRepository $produtoRepository,
                                MovimentacaoEstoqueRepository $movimentacaoEstoqueRepository)
    {
        $this->estoqueRepository             = $estoqueRepository;
        $this->movimentacaoEstoqueRepository = $movimentacaoEstoqueRepository;
        $this->produtoRepository             = $produtoRepository;
    }

    /**
     * Handle the event.
     *
     * @param CadastroCompra $event
     * @return void
     */
    public function handle(CadastroCompra $event)
    {
        CadastroCompraJob::dispatch(
            $this->estoqueRepository,
            $this->produtoRepository,
            $this->movimentacaoEstoqueRepository)->delay(now()->addSeconds(10));
    }
}
