<?php

namespace App\Http\Controllers;

use App\Models\Colaborador;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

class HomeController extends Controller
{
    /**
     * @return Application|Factory|View
     */
    public function index()
    {
        /** @var Colaborador $colaborador */
        $colaborador = session('colaborador');
        $nomeUsuario = $colaborador->nome;
        return view('home', compact('nomeUsuario'));
    }
}
