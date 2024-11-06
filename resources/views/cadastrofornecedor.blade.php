@extends('layouts.principal')

@section('titulo', 'Cadastro de Fornecedores')

@section('conteudo')
    <div class="container mt-5">
        <h2 class="text-center">Cadastrar Fornecedor</h2>

        <form method="POST" action="{{ isset($fornecedor) ? route('fornecedor.editar', ['id' => $fornecedor->id]) : route('fornecedor.create') }}" class="mx-auto mt-4 p-4 border rounded">
            @csrf

            @if(isset($fornecedor))
                <div class="form-group">
                    <label for="ativo">Ativo:</label>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="ativo" id="ativo_sim" value="1" {{ $fornecedor->ativo ? 'checked' : '' }}>
                        <label class="form-check-label" for="ativo_sim">
                            Sim
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="ativo" id="ativo_nao" value="0" {{ !$fornecedor->ativo ? 'checked' : '' }}>
                        <label class="form-check-label" for="ativo_nao">
                            Não
                        </label>
                    </div>
                </div>
            @endif

            @if(!isset($fornecedor))
                <input type="hidden" name="ativo" value="1">
            @endif

            <div class="form-group">
                <label for="nome">Nome:</label>
                <input type="text" id="nome" name="nome" required class="form-control" value="{{ isset($fornecedor) ? $fornecedor->nome : '' }}">
            </div>

            <div class="form-group">
                <label for="email">Email:</label>
                <input type="text" id="email" name="email" required class="form-control" value="{{ isset($fornecedor) ? $fornecedor->email : '' }}">
            </div>

            <div class="form-group">
                <label for="email">CNPJ:</label>
                <input type="text" id="cnpj" name="cnpj" required class="form-control" value="{{ isset($fornecedor) ? $fornecedor->cnpj : '' }}">
            </div>

            <div class="form-group">
                <label for="celular">Celular:</label>
                <input type="text" id="celular" name="celular" required class="form-control" value="{{ isset($fornecedor) ? $fornecedor->celular : '' }}">
            </div>

            <div class="form-group text-center">
                <div class="row">
                    <div class="col-md-6">
                        <a href="{{ route('app.home') }}" class="btn btn-danger btn-block">Voltar</a>
                    </div>
                    <div class="col-md-6 mb-2 mb-md-0">
                        <button type="submit" class="btn btn-primary btn-block">{{ isset($fornecedor) ? 'Atualizar Fornecedor' : 'Cadastrar Fornecedor' }}</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
