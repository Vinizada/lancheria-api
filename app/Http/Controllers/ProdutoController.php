<?php

namespace App\Http\Controllers;

use App\Models\Produto;
use App\Repositories\Contracts\ProdutoRepository;
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
     * @return JsonResponse
     */
    public function create(Request $request)
    {
        $validator = $this->validateRequest($request);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $this->produtoRepository->create($this->modelProduto, $request->all());

        return response()->json(['message' => 'Produto criado com sucesso!']);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Validation\Validator|mixed
     */
    public function validateRequest(Request $request)
    {
        $regras = [
            'nome'           => 'required|min:3|max:40',
            'preco'          => 'required|numeric',
            'estoque_minimo' => 'numeric',
            'ativo'          => 'required|numeric',
        ];

        $feedback = [
            'nome.required'      => 'O campo nome é obrigatório!',
            'nome.min'           => 'O campo nome deve ter no mínimo 3 caracteres!',
            'nome.max'           => 'O campo nome deve ter no máximo 40 caracteres!',
            'preco.required'     => 'O campo preço é obrigatório!',
            'preco.numeric'      => 'O campo preço deve ser um valor numérico!',
            'estoque_minimo'     => 'O campo de estoque precisa ser um número!',
            'ativo.required'     => 'O campo ativo é obrigatório!',
            'ativo.numeric'      => 'O campo ativo deve ser um valor numérico!',
        ];

        return Validator::make($request->all(), $regras, $feedback);
    }

    /**
     * @return mixed
     */
    public function listar()
    {
        return $this->produtoRepository->getProdutos();
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
