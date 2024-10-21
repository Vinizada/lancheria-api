<?php

namespace App\Http\Controllers;

use App\Helpers\Utils;
use App\Models\Fornecedor;
use App\Repositories\Contracts\FornecedorRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FornecedorController extends ModelController
{
    /** @var FornecedorRepository */
    private $fornecedorRepository;
    private $modelFornecedor;

    public function __construct(FornecedorRepository $clienteRepository)
    {
        $this->clienteRepository = $clienteRepository;
        $this->modelCliente      = app(Fornecedor::class);
    }

    public function index(Request $request)
    {
        $nomeUsuario = app(Utils::class)->retornaNomeColaborador();

        return view('cadastrofornecedor', compact('nomeUsuario'));
    }

    public function create(Request $request)
    {
        $validator = $this->validateRequest($request);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $this->clienteRepository->create($this->modelCliente, $request->all());

        return app(HomeController::class)->index();
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

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Validation\Validator|mixed
     */
    public function validateRequest(Request $request)
    {
        $regras = [
            'nome'     => 'required|min:3|max:40',
            'cnpj'     => 'required|min:3|max:40',
            'email'    => 'required',
            'celular'  => 'required|numeric',
        ];

        $feedback = [
            'nome.required'  => 'O campo nome é obrigatório!',
            'nome.min'       => 'O campo nome deve ter no mínimo 3 caracteres!',
            'nome.max'       => 'O campo nome deve ter no máximo 40 caracteres!',
            'email.required' => 'O campo email é obrigatório!',
            'celular'        => 'O campo de celular precisa ser um número!',
        ];

        return Validator::make($request->all(), $regras, $feedback);
    }
}
