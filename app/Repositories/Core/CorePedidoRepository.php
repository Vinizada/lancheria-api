<?php

namespace App\Repositories\Core;

use App\Models\Pedido;
use App\Repositories\Contracts\BaseRepositoryImpl;
use App\Repositories\Contracts\PedidoRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class CorePedidoRepository extends BaseRepositoryImpl implements PedidoRepository
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
     * @return Builder[]|Collection
     */
    public function getPedidos()
    {
        return Pedido::query()
            ->selectRaw('pedidos.id as id,
                              clientes.nome as cliente,
                              metodos_pagamento.metodo as forma_pagamento,
                              pedidos.data as data,
                              pedidos.valor_total as valor_total,
                              pedidos.quantidade_itens as quantidade_itens,
                              pedidos.status as status')
            ->join('clientes', 'clientes.id', '=', 'pedidos.cliente_id')
            ->join('metodos_pagamento', 'metodos_pagamento.id', '=', 'pedidos.metodo_id')
            ->get();
    }

    public function getPedidosFiltrados($filtros)
    {
        $query = Pedido::query()
            ->selectRaw('pedidos.id as id,
                              clientes.nome as cliente,
                              metodos_pagamento.metodo as forma_pagamento,
                              pedidos.data as data,
                              pedidos.valor_total as valor_total,
                              pedidos.quantidade_itens as quantidade_itens,
                              pedidos.status as status')
            ->join('clientes', 'clientes.id', '=', 'pedidos.cliente_id')
            ->join('metodos_pagamento', 'metodos_pagamento.id', '=', 'pedidos.metodo_id');

        if ($filtros['pedido_id']) {
            $query->where('pedidos.id', $filtros['pedido_id']);
            return $query->get();
        }

        if ($filtros['cliente_id']) {
            $query->where('pedidos.cliente_id', $filtros['cliente_id']);
        }

        if ($filtros['data_inicio']) {
            $query->where('pedidos.data', '>=', $filtros['data_inicio']);
        }

        return $query->get();
    }
}
