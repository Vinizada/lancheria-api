<?php

namespace App\Repositories\Contracts;

 interface ProdutoRepository extends BaseRepository
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
     public function getProdutos();

     /**
      * @param $produtoId
      * @return mixed
      */
     public function buscaProduto($produtoId);

     /**
      * @param $produtoId
      * @return mixed
      */
     public function deletaProduto($produtoId);

     /**
      * @param $produtoId
      * @param array $dadosAlterados
      * @return mixed
      */
     public function updateProduto($produtoId, array $dadosAlterados);
 }


