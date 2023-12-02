<?php

namespace App\Repositories\Core;

use App\Repositories\Contracts\BaseRepositoryImpl;
use App\Repositories\Contracts\ClienteRepository;

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
}
