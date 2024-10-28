<?php

namespace App\Http\Controllers;

use App\Helpers\Utils;
use App\Repositories\Contracts\ClienteRepository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

class HomeController extends Controller
{
    /**
     * @var ClienteRepository
     */
    private $clienteRepository;

    public function __construct(ClienteRepository $clienteRepository)
    {
        $this->clienteRepository = $clienteRepository;
    }

    /**
     * @return Application|Factory|View
     */
    public function index()
    {
        $nomeUsuario = app(Utils::class)->retornaNomeColaborador();
        $clientes    = $this->clienteRepository->getClientes();
        return view('home', compact('nomeUsuario', 'clientes'));
    }
}
