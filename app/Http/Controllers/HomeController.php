<?php

namespace App\Http\Controllers;

use App\Helpers\Utils;
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
        $nomeUsuario = app(Utils::class)->retornaNomeColaborador();
        return view('home', compact('nomeUsuario'));
    }
}
