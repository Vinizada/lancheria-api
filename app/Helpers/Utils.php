<?php

namespace App\Helpers;

use App\Models\Colaborador;

class Utils
{
    /**
     * @return string
     */
    public function retornaNomeColaborador()
    {
        /** @var Colaborador $colaborador */
        $colaborador = session('colaborador');
        return $colaborador->nome;
    }
}
