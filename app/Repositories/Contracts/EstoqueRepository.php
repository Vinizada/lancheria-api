<?php

namespace App\Repositories\Contracts;

 use App\Models\Colaborador;

 interface EstoqueRepository extends BaseRepository
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
      * @param Colaborador $colaborador
      * @param $estoque
      * @param $tipoMovimentacao
      * @return mixed
      */
     public function movimentacaoEstoque(Colaborador $colaborador, $estoque, $tipoMovimentacao);

     /**
      * @param $estoque
      * @return mixed
      */
     public function existeEstoque($estoque);

     /**
      * @param $produtoId
      * @param array $dadosAlterados
      * @return mixed
      */
     public function updateEstoque($produtoId, array $dadosAlterados);
 }


