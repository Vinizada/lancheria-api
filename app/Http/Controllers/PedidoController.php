<?php

namespace App\Http\Controllers;

use App\Helpers\Utils;
use App\Models\Colaborador;
use App\Models\Produto;
use App\Repositories\Contracts\ClienteRepository;
use App\Repositories\Contracts\EstoqueRepository;
use App\Repositories\Contracts\MetodoPagamentoRepository;
use App\Repositories\Contracts\ProdutoRepository;
use App\Repositories\Core\CoreMetodoPagamentoRepository;
use App\Services\EstoqueService;
use App\Services\PedidoService;
use App\Services\ProdutoService;
use Illuminate\Http\JsonResponse;
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

    /** @var PedidoService  */
    private $pedidoService;

    /** @var ProdutoService  */
    private $produtoService;

    public function __construct(ProdutoRepository $produtoRepository,
                                EstoqueRepository $estoqueRepository,
                                ClienteRepository $clienteRepository,
                                MetodoPagamentoRepository $metodoPagamentoRepository,
                                EstoqueService $estoqueService,
                                PedidoService $pedidoService,
                                ProdutoService $produtoService)
    {
        $this->produtoRepository = $produtoRepository;
        $this->estoqueRepository = $estoqueRepository;
        $this->clienteRepository = $clienteRepository;
        $this->metodoPagamentoRepository = $metodoPagamentoRepository;
        $this->estoqueService    = $estoqueService;
        $this->pedidoService     = $pedidoService;
        $this->produtoService    = $produtoService;
    }
    public function create(Request $request)
    {
        /** @var Colaborador $colaborador */
        $colaborador    = auth()->user();
        $produtos       = $this->produtoService->processaProdutos($request->get('produtos'));
        $cliente        = $this->clienteRepository->getCliente($request->get('cliente_id'));
        $formaPagamento = $this->metodoPagamentoRepository->getMetodo($request->get('forma_pagamento_id'));
        $valorTotal     = $request->get('valor_total');

        $this->pedidoService->storePedido($colaborador, $produtos, $cliente, $formaPagamento, $valorTotal);

        return redirect()->route('pedido.cadastro', ['cliente_id' => $cliente->id])
            ->with('success', 'Pedido enviado com sucesso!');
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
        $clienteSelecionado = $this->clienteRepository->getCliente($request['cliente_id']);
        $produtos           = $this->produtoRepository->getProdutos();
        $metodosDePagamento = $this->metodoPagamentoRepository->getMetodos();
        $nomeUsuario = app(Utils::class)->retornaNomeColaborador();

        return view('pedido', compact('produtos', 'nomeUsuario', 'clienteSelecionado', 'metodosDePagamento'));
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function buscarProdutos(Request $request)
    {
        $termo = $request->input('nome');
        $produtos = $this->produtoRepository->getProdutosFiltrados($termo);
        return response()->json($produtos);
    }

    public function buscaFormasPagamento()
    {
        $formaPagamento = $this->metodoPagamentoRepository->getMetodos();
        return response()->json($formaPagamento);
    }
}
