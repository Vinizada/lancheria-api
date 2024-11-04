<?php

namespace App\Helpers;

use App\Models\Colaborador;
use Illuminate\Support\Facades\Auth;

class Utils
{
    /**
     * @return string
     */
    public function retornaNomeColaborador()
    {
        /** @var Colaborador $colaborador */
        $colaborador = Auth::guard('colaborador')->user();
        return $colaborador->nome;
    }
}
