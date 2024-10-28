<?php

namespace App\Repositories\Core;

use App\Constants\TipoMovimentacao;
use App\Models\MovimentacaoEstoque;
use App\Models\Produto;
use App\Repositories\Contracts\BaseRepositoryImpl;
use App\Repositories\Contracts\MovimentacaoEstoqueRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

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
            ->join('lote', 'lote.movimentacao_id', '=', 'movimentacao_estoque.id')
            ->where('movimentacao_estoque.produto_id', $produto->id)
            ->where('tipo_movimentacao', $movimentacao)
            ->get();
    }

    /**
     * @param Produto $produto
     * @param $movimentacao
     * @return MovimentacaoEstoque
     */
    public function buscaUltimaMovimentacaoProduto(Produto $produto, $movimentacao)
    {
         return MovimentacaoEstoque::query()
             ->where('produto_id', $produto->id)
             ->where('tipo_movimentacao', $movimentacao)
             ->whereNotNull('valor_unitario')
             ->orderByDesc('data_movimentacao')
             ->value('valor_unitario');
    }
}
