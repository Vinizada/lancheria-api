<?php

namespace App\Repositories\Core;

use App\Models\MetodoPagamento;
use App\Repositories\Contracts\BaseRepositoryImpl;
use App\Repositories\Contracts\MetodoPagamentoRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class CoreMetodoPagamentoRepository extends BaseRepositoryImpl implements MetodoPagamentoRepository
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

    public function getMetodos()
    {
        return MetodoPagamento::query()
            ->get();
    }

    /**
     * @param $id
     * @return Builder|Model|mixed|object|null
     */
    public function getMetodo($id)
    {
        return MetodoPagamento::query()
            ->where('id', $id)
            ->first();
    }
}
