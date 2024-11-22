<?php

namespace App\Http\Controllers;

use App\Repositories\Contracts\IndicadoresRepository;
use Illuminate\Http\Request;

class IndicadoresController extends Controller
{
    /**
     * @var IndicadoresRepository
     */
    private $indicadoresRepository;

    public function __construct(IndicadoresRepository $indicadoresRepository)
    {
        $this->indicadoresRepository = $indicadoresRepository;
    }

    public function getIndicadores($periodo = 'mesAtual')
    {
        $indicadores = $this->indicadoresRepository->getIndicadores($periodo);
        return json_encode($indicadores);
    }
}
