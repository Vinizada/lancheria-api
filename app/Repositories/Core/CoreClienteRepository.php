<?php

namespace App\Repositories\Core;

use App\Models\Cliente;
use App\Repositories\Contracts\BaseRepositoryImpl;
use App\Repositories\Contracts\ClienteRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class CoreClienteRepository extends BaseRepositoryImpl implements ClienteRepository
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
    public function getClientes()
    {
        return Cliente::query()
            ->get();
    }
}
