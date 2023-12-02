<?php

namespace App\Repositories\Contracts;

 interface PerfilAcessosRepository extends BaseRepository
 {
     /**
      * @param $model
      * @param array $data
      * @return mixed
      */
     public function create($model, array $data);

     /**
      * @return boolean
      */
     public function exists($model);
 }


