<?php

namespace App\Repositories\Contracts;

 use App\Models\MovimentacaoEstoque;

 interface LoteRepository extends BaseRepository
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
      * @param MovimentacaoEstoque $movimentacaoEstoque
      * @param $dataValidade
      * @return mixed
      */
     public function controleLote(MovimentacaoEstoque $movimentacaoEstoque, $dataValidade);
 }


