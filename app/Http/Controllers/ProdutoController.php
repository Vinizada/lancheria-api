<?php

namespace App\Http\Controllers;

use App\Helpers\Utils;
use App\Models\Produto;
use App\Repositories\Contracts\CategoriaRepository;
use App\Repositories\Contracts\ProdutoRepository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

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
        $nomeUsuario = app(Utils::class)->retornaNomeColaborador();
        $categorias = app(CategoriaRepository::class)->getCategorias();
        return view('cadastroproduto', compact('nomeUsuario','categorias'));
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

        $produto = $this->produtoRepository->create($this->modelProduto, $request->all());

        $file = $request->file('imagem');
        $filename = $produto->id . '.' . $file->getClientOriginalExtension();
        $file->storeAs('produtos', $filename, 'public');

        return $this->listar($request);
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
            'estoque_minimo' => 'numeric',
            'imagem'         => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];

        $feedback = [
            'nome.required'        => 'O campo nome é obrigatório!',
            'nome.min'             => 'O campo nome deve ter no mínimo 3 caracteres!',
            'nome.max'             => 'O campo nome deve ter no máximo 40 caracteres!',
            'preco_venda.required' => 'O campo preço de venda é obrigatório!',
            'preco_venda.numeric'  => 'O campo preço de venda deve ser um valor numérico!',
            'estoque_minimo'       => 'O campo de estoque precisa ser um número!',
            'imagem'               => 'Favor cadastrar uma imagem!',
        ];

        return Validator::make($request->all(), $regras, $feedback);
    }

    /**
     * @return mixed
     */
    public function listar()
    {
        $produtos = $this->produtoRepository->getProdutos();
        $nomeUsuario = app(Utils::class)->retornaNomeColaborador();

        return view('produtos', compact('produtos', 'nomeUsuario'));
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
        return $this->listar();
    }

    /**
     * @param Request $request
     * @return JsonResponse|mixed
     */
    public function editar(Request $request)
    {
        $validator = $this->validateRequest($request);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $dados = $request->except('_token');

        $this->produtoRepository->updateProduto($request['id'], $dados);

        return $this->listar($request);
    }

    public function editarProduto($id)
    {
        /** @var Produto $produto */
        $produto = $this->produtoRepository->buscaProduto($id);
        $nomeUsuario = app(Utils::class)->retornaNomeColaborador();

        return view('cadastroproduto', compact('produto', 'nomeUsuario'));
    }

    /**
     * @param $id
     * @return JsonResponse|BinaryFileResponse
     */
    public function imagem($id)
    {
        $extensoes = ['jpg', 'jpeg', 'png', 'gif'];

        foreach ($extensoes as $ext) {
            $path = storage_path('app/public/produtos/' . $id . '.' . $ext);

            if (file_exists($path)) {
                return response()->file($path);
            }
        }

        return response()->json(['message' => 'Imagem não encontrada'], 404);
    }
}
