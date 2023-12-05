<?php

namespace App\Http\Controllers;

use App\Models\Produto;
use App\Repositories\Contracts\ProdutoRepository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProdutoController extends ModelController
{
    /** @var ProdutoRepository */
    private $produtoRepository;

    private $modelProduto;

    public function __construct(ProdutoRepository $produtoRepository)
    {
        $this->produtoRepository = $produtoRepository;
        $this->modelProduto      = app(Produto::class);
    }

    /**
     * @param Request $request
     * @return Application|Factory|View|mixed
     */
    public function index(Request $request)
    {
        return view('cadastroproduto');
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function create(Request $request)
    {
        $validator = $this->validateRequest($request);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $this->produtoRepository->create($this->modelProduto, $request->all());

        return $this->listar();
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Validation\Validator|mixed
     */
    public function validateRequest(Request $request)
    {
        $regras = [
            'nome'           => 'required|min:3|max:40',
            'preco_venda'    => 'required|numeric',
            'preco_custo'    => 'required|numeric',
            'estoque_minimo' => 'numeric',
            'ativo'          => 'required',
        ];

        $feedback = [
            'nome.required'        => 'O campo nome é obrigatório!',
            'nome.min'             => 'O campo nome deve ter no mínimo 3 caracteres!',
            'nome.max'             => 'O campo nome deve ter no máximo 40 caracteres!',
            'preco_venda.required' => 'O campo preço de venda é obrigatório!',
            'preco_venda.numeric'  => 'O campo preço de venda deve ser um valor numérico!',
            'preco_custo.required' => 'O campo preço de custo é obrigatório!',
            'preco_custo.numeric'  => 'O campo preço de custo deve ser um valor numérico!',
            'estoque_minimo'       => 'O campo de estoque precisa ser um número!',
            'ativo.required'       => 'O campo ativo é obrigatório!',
        ];

        return Validator::make($request->all(), $regras, $feedback);
    }

    /**
     * @return mixed
     */
    public function listar()
    {
        $produtos = $this->produtoRepository->getProdutos();

        return view('produtos', compact('produtos'));
    }

    /**
     * @param $produtoId
     * @return mixed
     */
    public function buscar($id)
    {
        return $this->produtoRepository->buscaProduto($id);
    }

    public function deletar($id)
    {
        $this->produtoRepository->deletaProduto($id);
    }

    public function editar($id, $dados)
    {
        // TODO: Implement editar() method.
    }
}
