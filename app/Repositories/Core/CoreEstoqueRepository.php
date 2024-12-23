<?php

namespace App\Repositories\Core;

use App\Events\CadastroCompra;
use App\Models\Colaborador;
use App\Models\Estoque;
use App\Models\MovimentacaoEstoque;
use App\Repositories\Contracts\BaseRepositoryImpl;
use App\Repositories\Contracts\EstoqueRepository;
use App\Repositories\Contracts\LoteRepository;
use App\Repositories\Contracts\MovimentacaoEstoqueRepository;
use Carbon\Carbon;

class CoreEstoqueRepository extends BaseRepositoryImpl implements EstoqueRepository
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
     * @param Colaborador $colaborador
     * @param $estoque
     * @param $tipoMovimentacao
     * @return void
     */
    public function movimentacaoEstoque(Colaborador $colaborador, $estoque, $tipoMovimentacao)
    {
        if (!$this->existeEstoque($estoque)) {
            $model = app(Estoque::class);
            $this->create($model, $estoque);
        };

        /** @var MovimentacaoEstoqueRepository $movimentacaoEstoque */
        $movimentacaoEstoque = app(MovimentacaoEstoqueRepository::class);
        $modelMovimentacao   = app(MovimentacaoEstoque::class);

        $movimentacao = [
            'produto_id'         => $estoque['produto_id'],
            'quantidade'         => $estoque['quantidade'],
            'data_movimentacao'  => Carbon::now()->format('Y-m-d H:i:s'),
            'colaborador_id'     => $colaborador->id,
            'valor_total'        => $estoque['quantidade'] * $estoque['valor_custo_unitario'],
            'valor_unitario'     => $estoque['valor_custo_unitario'],
            'tipo_movimentacao'  => $tipoMovimentacao,
        ];

        $movimentacao = $movimentacaoEstoque->create($modelMovimentacao, $movimentacao);

        /** @var LoteRepository $controleLote */
        $controleLote = app(LoteRepository::class);
        $controleLote->controleLote($movimentacao, $estoque['validade']);
    }

    public function existeEstoque($estoque)
    {
        return Estoque::query()
            ->where('produto_id', $estoque['produto_id'])
            ->exists();
    }

    public function updateEstoque($produtoId, array $dadosAlterados)
    {
        return Estoque::query()
            ->where('produto_id', $produtoId)
            ->update($dadosAlterados);
    }
}
