<?php

namespace App\Services;

use App\Constants\StatusPedido;
use App\Constants\TipoMovimentacao;
use App\Events\CadastroCompra;
use App\Models\Cliente;
use App\Models\Colaborador;
use App\Models\MetodoPagamento;
use App\Models\Pedido;
use App\Models\PedidoItem;
use App\Models\Produto;
use App\Repositories\Contracts\EstoqueRepository;
use App\Repositories\Contracts\MovimentacaoEstoqueRepository;
use App\Repositories\Contracts\PedidoRepository;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Collection;

class PedidoService
{

    /** @var MovimentacaoEstoqueRepository */
    private $movimentacaoEstoqueRepository;

    /** @var EstoqueRepository */
    private $estoqueRepository;

    /** @var PedidoRepository */
    private $pedidoRepository;


    public function __construct(MovimentacaoEstoqueRepository $movimentacaoEstoqueRepository,
                                EstoqueRepository $estoqueRepository,
                                PedidoRepository $pedidoRepository)
    {
        $this->estoqueRepository             = $estoqueRepository;
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
            $itens = $this->pedidoRepository->create(App(PedidoItem::class), $pedidoItem);
        }
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
