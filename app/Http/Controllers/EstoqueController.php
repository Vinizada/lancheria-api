<?php

namespace App\Http\Controllers;

use App\Constants\TipoMovimentacao;
use App\Helpers\Utils;
use App\Models\Colaborador;
use App\Models\Produto;
use App\Repositories\Contracts\EstoqueRepository;
use App\Repositories\Contracts\ProdutoRepository;
use App\Services\EstoqueService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EstoqueController
{

    /** @var ProdutoRepository */
    private $produtoRepository;

    /** @var EstoqueRepository */
    private $estoqueRepository;

    /** @var EstoqueService  */
    private $estoqueService;

    public function __construct(ProdutoRepository $produtoRepository, EstoqueRepository $estoqueRepository, EstoqueService $estoqueService)
    {
        $this->produtoRepository = $produtoRepository;
        $this->estoqueRepository = $estoqueRepository;
        $this->estoqueService    = $estoqueService;
    }

    /**
     * @param Request $request
     * @return Application|Factory|View|mixed
     */
    public function index(Request $request, $origem)
    {
        $produtos = $this->produtoRepository->getProdutos();
        $nomeUsuario = app(Utils::class)->retornaNomeColaborador();
        $produtoSelecionado = $request->input('id');

        return view('estoque', compact('produtos', 'produtoSelecionado', 'nomeUsuario', 'origem'));
    }

    /**
     * @param Request $request
     * @return JsonResponse|RedirectResponse|mixed
     * @throws \Exception
     */
    public function create(Request $request)
    {
        $colaborador = app(Utils::class)->retornaColaboradorLogado();

        $validator = $this->validateRequest($request);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $this->estoqueRepository->movimentacaoEstoque($colaborador, $request->all(), TipoMovimentacao::ENTRADA);

        /** @var Produto $produto */
        $produto = $this->produtoRepository->buscaProduto($request->get('produto_id'));

        $this->estoqueService->atualizaEstoque($produto);

        return redirect()->route('produto.listar');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Validation\Validator|mixed
     */
    public function validateRequest(Request $request)
    {
        $regras = [
            'produto_id'    => 'required|numeric',
            'quantidade'    => 'required|numeric',
        ];

        $feedback = [
            'produto_id.required'  => 'O produto é obrigatório!',
            'produto_id.numeric'   => 'O campo deve ser numérico!',
            'quantidade.required'  => 'O campo quantidade é obrigatório!',
            'quantidade.numeric'   => 'O campo quantidade deve ser um valor numérico!',
            'validade.required'    => 'A data de validade é obrigatória!',
        ];

        return Validator::make($request->all(), $regras, $feedback);
    }

    /**
     * @param Request $request
     * @return Application|Factory|View
     */
    public function listarComprasProduto(Request $request)
    {
        /** @var Produto $produto */
        $produto     = $this->produtoRepository->buscaProduto($request->input('id'));
        $nomeUsuario = app(Utils::class)->retornaNomeColaborador();
        $compras     = $this->estoqueService->getMovimentacoesProduto($produto);

        return view('compras', compact('produto', 'compras', 'nomeUsuario'));
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

    public function listar()
    {
        // TODO: Implement listar() method.
    }
}
