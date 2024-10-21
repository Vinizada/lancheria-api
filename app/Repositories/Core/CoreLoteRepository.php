<?php

namespace App\Repositories\Core;

use App\Models\Lote;
use App\Models\MovimentacaoEstoque;
use App\Repositories\Contracts\BaseRepositoryImpl;
use App\Repositories\Contracts\LoteRepository;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class CoreLoteRepository extends BaseRepositoryImpl implements LoteRepository
{
    protected $model;

    public function __construct(Lote $lote)
    {
        $this->model = $lote;
    }

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

    public function controleLote(MovimentacaoEstoque $movimentacaoEstoque, $dataValidade)
    {
        $controleLote = [
            'movimentacao_id' => $movimentacaoEstoque->id,
            'produto_id'      => $movimentacaoEstoque->produto_id,
            'data_validade'   => $dataValidade,
            ];

        Log::debug('Teste' . $controleLote['movimentacao_id']);

        $this->create($this->model, $controleLote);
    }
}
