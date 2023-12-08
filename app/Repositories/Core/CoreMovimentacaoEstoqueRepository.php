<?php

namespace App\Repositories\Core;

use App\Constants\TipoMovimentacao;
use App\Models\MovimentacaoEstoque;
use App\Models\Produto;
use App\Repositories\Contracts\BaseRepositoryImpl;
use App\Repositories\Contracts\MovimentacaoEstoqueRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class CoreMovimentacaoEstoqueRepository extends BaseRepositoryImpl implements MovimentacaoEstoqueRepository
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
     * @param Produto $produto
     * @param $movimentacao
     * @return Builder[]|Collection|mixed
     */
    public function buscaMovimentacoesProduto(Produto $produto, $movimentacao)
    {
        return MovimentacaoEstoque::query()
            ->where('produto_id', $produto->id)
            ->where('tipo_movimentacao', $movimentacao)
            ->get();
    }
}
