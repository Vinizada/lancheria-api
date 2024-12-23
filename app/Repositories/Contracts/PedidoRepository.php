<?php

namespace App\Repositories\Contracts;

 interface PedidoRepository extends BaseRepository
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
     public function getPedidos();

     public function getPedidosFiltrados($filtros);
 }


