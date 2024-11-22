<?php

namespace App\Repositories\Core;

use App\Constants\StatusPedido;
use App\Models\Pedido;
use App\Models\PedidoItem;
use App\Repositories\Contracts\BaseRepositoryImpl;
use App\Repositories\Contracts\IndicadoresRepository;
use Carbon\Carbon;

class CoreIndicadoresRepository extends BaseRepositoryImpl implements IndicadoresRepository
{
    /**
     * @param $model
     * @param array $data
     * @return mixed
     */
    public function create($model, array $data)
    {
        $query = $model->newQuery();
        return $query->create($data);
    }

    /**
     * @return boolean
     */
    public function exists($model)
    {
        return $model->newQuery()->count();
    }

    /**
     * @param $periodo
     * @return array
     */
    public function getIndicadores($periodo): array
    {
        $dataFiltro = $periodo === 'mesAtual'
            ? Carbon::now()->startOfMonth()
            : Carbon::now()->subDays((int) $periodo);

        $totalVendas = $this->getTotalVendas($dataFiltro);
        [$lucroPercentual, $lucroReal] = $this->getLucros($dataFiltro);
        $pendentePagamento = $this->getPendentesPagamento($dataFiltro);

        return ['totalVendas'       => $totalVendas,
                'lucroPercentual'   => $lucroPercentual,
                'lucroReal'         => $lucroReal,
                'pendentePagamento' => $pendentePagamento];
    }

    private function getTotalVendas($dataFiltro)
    {
        return Pedido::query()
            ->where('data', '>=', $dataFiltro)
            ->where('status', '!=', StatusPedido::CANCELADO)
            ->sum('valor_total');
    }

    private function getLucros($dataFiltro)
    {
        $valores = PedidoItem::query()
            ->selectRaw('sum((case when coalesce(produtos.preco_medio,0.00) = 0.00 then
                                    produtos.preco_custo
                                    else
                                    produtos.preco_medio
                                    end) * pedido_itens.quantidade) as custo_total,
                                   sum(pedido_itens.quantidade * pedido_itens.preco_unitario) as faturado_total')
            ->join('pedidos', 'pedidos.id', '=', 'pedido_itens.pedido_id')
            ->join('produtos', 'produtos.id', '=', 'pedido_itens.produto_id')
            ->where('pedidos.data', '>=', $dataFiltro)
            ->where('pedidos.status', '!=', StatusPedido::CANCELADO)
            ->first();

        if ($valores->faturado_total > 0) {
            $lucroPercentual = round((($valores->faturado_total - $valores->custo_total) / $valores->faturado_total) * 100,2);
            $lucroReal       = round($valores->faturado_total - $valores->custo_total, 2);

            return [$lucroPercentual, $lucroReal];
        }

        return [0, 0];
    }

    private function getPendentesPagamento($dataFiltro)
    {
        return Pedido::query()
            ->where('data', '>=', $dataFiltro)
            ->where('status', '=', StatusPedido::AGUARDANDO_PAGAMENTO)
            ->sum('valor_total');
    }
}
