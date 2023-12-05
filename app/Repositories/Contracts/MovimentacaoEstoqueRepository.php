<?php

namespace App\Repositories\Contracts;

use App\Models\Produto;

 interface MovimentacaoEstoqueRepository extends BaseRepository
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
      * @param Produto $produto
      * @return mixed
      */
     public function buscaMovimentacoesProduto(Produto $produto);
 }

