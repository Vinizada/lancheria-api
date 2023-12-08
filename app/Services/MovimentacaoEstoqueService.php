<?php

namespace App\Services;

use App\Repositories\Contracts\EstoqueRepository;
use App\Repositories\Contracts\MovimentacaoEstoqueRepository;

class MovimentacaoEstoqueService
{
    public function __construct(MovimentacaoEstoqueRepository $movimentacaoEstoqueRepository, EstoqueRepository $estoqueRepository)
    {
        $this->estoqueRepository             = $estoqueRepository;
        $this->movimentacaoEstoqueRepository = $movimentacaoEstoqueRepository;
    }
}
