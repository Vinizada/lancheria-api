<?php

namespace App\Http\Controllers;

use App\Helpers\Utils;
use App\Repositories\Contracts\ClienteRepository;
use App\Repositories\Contracts\EstoqueRepository;
use App\Repositories\Contracts\MetodoPagamentoRepository;
use App\Repositories\Contracts\ProdutoRepository;
use App\Repositories\Core\CoreMetodoPagamentoRepository;
use App\Services\EstoqueService;
use Illuminate\Http\Request;

class PedidoController extends ModelController
{
    /** @var ProdutoRepository */
    private $produtoRepository;

    /** @var EstoqueRepository */
    private $estoqueRepository;

    /**
     * @var ClienteRepository
     */
    private $clienteRepository;

    /** @var CoreMetodoPagamentoRepository */
    private $metodoPagamentoRepository;

    /** @var EstoqueService  */
    private $estoqueService;

    public function __construct(ProdutoRepository $produtoRepository, EstoqueRepository $estoqueRepository, ClienteRepository $clienteRepository, MetodoPagamentoRepository $metodoPagamentoRepository,EstoqueService $estoqueService)
    {
        $this->produtoRepository = $produtoRepository;
        $this->estoqueRepository = $estoqueRepository;
        $this->clienteRepository = $clienteRepository;
        $this->metodoPagamentoRepository = $metodoPagamentoRepository;
        $this->estoqueService    = $estoqueService;
    }
    public function create(Request $request)
    {
        // TODO: Implement create() method.
    }

    public function validateRequest(Request $request)
    {
        // TODO: Implement validateRequest() method.
    }

    public function listar()
    {
        // TODO: Implement listar() method.
    }

    public function buscar($id)
    {
        // TODO: Implement buscar() method.
    }

    public function deletar($id)
    {
        // TODO: Implement deletar() method.
    }

    public function editar(Request $request)
    {
        // TODO: Implement editar() method.
    }

    public function index(Request $request)
    {
        $clientes           = $this->clienteRepository->getClientes();
        $produtos           = $this->produtoRepository->getProdutos();
        $metodosDePagamento = $this->metodoPagamentoRepository->getMetodos();
        $nomeUsuario = app(Utils::class)->retornaNomeColaborador();

        return view('pedido', compact('produtos', 'nomeUsuario', 'clientes', 'metodosDePagamento'));
    }

    public function buscarProdutos(Request $request)
    {
        $termo = $request->input('nome');
        $produtos = $this->produtoRepository->getProdutosFiltrados($termo);
        return response()->json($produtos);
    }
}
