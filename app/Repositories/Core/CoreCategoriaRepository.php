<?php

namespace App\Repositories\Core;

use App\Models\Categoria;
use App\Repositories\Contracts\BaseRepositoryImpl;
use App\Repositories\Contracts\CategoriaRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class CoreCategoriaRepository extends BaseRepositoryImpl implements CategoriaRepository
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
    public function getCategorias()
    {
        return Categoria::query()
            ->where('ativo', 1)
            ->get();
    }
}
