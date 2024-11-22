<?php

namespace App\Repositories\Contracts;

 interface IndicadoresRepository extends BaseRepository
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
      * @param $periodo
      * @return array
      */
     public function getIndicadores($periodo): array;
 }


