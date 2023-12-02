<?php

namespace App\Repositories\Contracts;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

abstract class BaseRepositoryImpl implements BaseRepository
{
    protected $modelClass;

    /**
     * @return Builder
     * @throws \Exception
     */
    public function newQuery()
    {
        return $this->getModel()->newQuery();
    }

    /**
     * @return Model
     * @throws \Exception
     */
    public function getModel()
    {
        if (!$this->modelClass) {
            throw new \Exception('Model não definido ' . get_class($this));
        }
        return app($this->modelClass);
    }

    /**
     * @param string $column
     * @param string|null $key
     * @return Collection
     * @throws \Exception
     */
    public function pluck($column, $key = null)
    {
        return $this->newQuery()->pluck($column, $key);
    }


    /**
     * Retrieves a record by his id
     * If fail is true $ fires ModelNotFoundException.
     *
     * @param int  $id
     * @param bool $fail
     *
     * @return Model
     */
    public function findByID($id, $fail = true)
    {
        if ($fail) {
            return $this->newQuery()->findOrFail($id);
        }
        return $this->newQuery()->find($id);
    }

    /**
     * @param $attributes
     * @return Builder|Model
     * @throws \Exception
     */
    public function createModel($attributes)
    {
        return $this->newQuery()->create($attributes);
    }

    /**
     * @param $id
     * @param $attributes
     * @return bool|int
     * @throws \Exception
     */
    public function updateModel($id, $attributes)
    {
        $query = $this->newQuery();
        $model = $query->find($id);

        if ($model) {
            return $model->update($attributes);
        }

        return false;
    }

    /**
     * @return string
     * @throws \Exception
     */
    public function getTable()
    {
        return $this->getModel()->getTable();
    }

    /**
     * @return array
     * @throws \Exception
     */
    public function getFillable()
    {
        return $this->getModel()->getFillable();
    }

    /**
     * Delete model by id
     * @param $id
     * @return bool|null
     * @throws \Exception
     */
    public function deleteModel($id)
    {
        $model = $this->findByID($id, false);

        if ($model) {
            return $model->delete();
        }

        return false;
    }
}
