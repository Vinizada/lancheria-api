<?php

namespace App\Repositories\Contracts;

 interface MetodoPagamentoRepository extends BaseRepository
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

     /**
      * @return mixed
      */
     public function getMetodos();

     /**
      * @param $id
      * @return mixed
      */
     public function getMetodo($id);
 }


