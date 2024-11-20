<?php

namespace App\Services;

use App\Constants\StatusPedido;
use App\Constants\TipoMovimentacao;
use App\Models\Cliente;
use App\Models\Colaborador;
use App\Models\MetodoPagamento;
use App\Models\MovimentacaoEstoque;
use App\Models\Pedido;
use App\Models\PedidoItem;
use App\Repositories\Contracts\MovimentacaoEstoqueRepository;
use App\Repositories\Contracts\PedidoRepository;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class PedidoService
{

    /** @var MovimentacaoEstoqueRepository */
    private $movimentacaoEstoqueRepository;

    /** @var EstoqueService */
    private $estoqueService;

    /** @var PedidoRepository */
    private $pedidoRepository;


    public function __construct(MovimentacaoEstoqueRepository $movimentacaoEstoqueRepository,
                                PedidoRepository $pedidoRepository,
                                EstoqueService $estoqueService)
    {
        $this->estoqueService                = $estoqueService;
        $this->movimentacaoEstoqueRepository = $movimentacaoEstoqueRepository;
        $this->pedidoRepository              = $pedidoRepository;
    }

    public function storePedido(Colaborador $colaborador,
                                Collection $produtos,
                                Cliente $cliente,
                                MetodoPagamento $metodoPagamento,
                                $valorTotal)
    {
        $pedidoCabecalho = $this->getPedidoCabecalho($colaborador, $produtos, $cliente, $metodoPagamento, $valorTotal);

        /** @var Pedido $pedido */
        $pedido = $this->pedidoRepository->create(app(Pedido::class), $pedidoCabecalho);

        $pedidoItens = $this->getPedidoItens($pedido, $produtos);

        foreach($pedidoItens as $pedidoItem) {
            /** @var PedidoItem $item */
            $item = $this->pedidoRepository->create(app(PedidoItem::class), $pedidoItem);
            $this->geraMovimentacaoEstoque($pedido, $item);
            $this->estoqueService->atualizaEstoque($item->produto());
        }
    }

    /**
     * @param Pedido $pedido
     * @param PedidoItem $item
     * @return void
     */
    private function geraMovimentacaoEstoque(Pedido $pedido, PedidoItem $item)
    {
        $this->movimentacaoEstoqueRepository->create(app(MovimentacaoEstoque::class), [
            'produto_id'        => $item->produto_id,
            'pedido_id'         => $pedido->id,
            'cliente_id'        => $pedido->cliente_id,
            'colaborador_id'    => $pedido->colaborador_id,
            'quantidade'        => $item->quantidade,
            'valor_total'       => $item->quantidade * $item->preco_unitario,
            'valor_unitario'    => $item->preco_unitario,
            'data_movimentacao' => Carbon::now(),
            'tipo_movimentacao' => TipoMovimentacao::SAIDA
        ]);
    }

    private function getPedidoCabecalho(Colaborador $colaborador,
                                        Collection $produtos,
                                        Cliente $cliente,
                                        MetodoPagamento $metodoPagamento,
                                        $valorTotal)
    {
        return [
            'cliente_id'       => $cliente->id,
            'metodo_id'        => $metodoPagamento->id,
            'valor_total'      => $valorTotal,
            'status'           => $metodoPagamento->isContaCliente()
                ? StatusPedido::AGUARDANDO_PAGAMENTO : StatusPedido::PAGO,
            'quantidade_itens' => $produtos->count(),
            'data'             => Carbon::now()->toDateTimeString(),
            'colaborador_id'   => $colaborador->id,
        ];
    }

    private function getPedidoItens(Pedido $pedido, Collection $produtos)
    {
        $pedidoItens = [];

        foreach ($produtos as $produto) {
            $pedidoItens[] = [
                'pedido_id'      => $pedido->id,
                'produto_id'     => $produto['produto_id'],
                'quantidade'     => $produto['quantidade'],
                'preco_unitario' => $produto['preco'],
                'preco_total'    => $produto['preco'] * $produto['quantidade'],
            ];
        }
        return $pedidoItens;
    }
}
