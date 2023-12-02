<?php

namespace App\Repositories\Core;

use App\Repositories\Contracts\AcessoRepository;
use App\Repositories\Contracts\BaseRepositoryImpl;

class CoreAcessoRepository extends BaseRepositoryImpl implements AcessoRepository
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
