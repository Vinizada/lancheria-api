<?php

namespace App\Repositories\Core;

use App\Models\Produto;
use App\Repositories\Contracts\BaseRepositoryImpl;
use App\Repositories\Contracts\ProdutoRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class CoreProdutoRepository extends BaseRepositoryImpl implements ProdutoRepository
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
     * @return Builder[]|Collection|mixed
     */
    public function getProdutos()
    {
        return Produto::query()
        ->where('ativo', 1)
        ->get();
    }

    /**
     * @param $produtoId
     * @return Builder|Model|mixed|object|null
     */
    public function buscaProduto($produtoId)
    {
        return Produto::query()
            ->where('id', $produtoId)
            ->first();
    }

    public function deletaProduto($produtoId)
    {
        return Produto::query()
            ->where('id', $produtoId)
            ->forceDelete();
    }

    public function updateProduto($produtoId, array $dadosAlterados)
    {
        return Produto::query()
            ->where('id', $produtoId)
            ->update($dadosAlterados);
    }
}
