@extends('layouts.default')

@section('titulo', 'Cadastro de Clientes')

@section('conteudo')
    <div class="container mt-5">
        <h2 class="text-center">Cadastrar Cliente</h2>

        <form method="POST" action="{{ isset($cliente) ? route('cliente.editar', ['id' => $cliente->id]) : route('cliente.create') }}" class="mx-auto mt-4 p-4 border rounded">
            @csrf

            @if(isset($cliente))
                <div class="form-group">
                    <label for="ativo">Ativo:</label>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="ativo" id="ativo_sim" value="1" {{ $cliente->ativo ? 'checked' : '' }}>
                        <label class="form-check-label" for="ativo_sim">
                            Sim
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="ativo" id="ativo_nao" value="0" {{ !$cliente->ativo ? 'checked' : '' }}>
                        <label class="form-check-label" for="ativo_nao">
                            Não
                        </label>
                    </div>
                </div>
            @endif

            @if(!isset($cliente))
                <input type="hidden" name="ativo" value="1">
            @endif

            <div class="form-group">
                <label for="nome">Nome:</label>
                <input type="text" id="nome" name="nome" required class="form-control" value="{{ isset($cliente) ? $cliente->nome : '' }}">
            </div>

            <div class="form-group">
                <label for="email">Email:</label>
                <input type="text" id="email" name="email" required class="form-control" value="{{ isset($cliente) ? $cliente->email : '' }}">
            </div>

            <div class="form-group">
                <label for="celular">Celular:</label>
                <input type="text" id="celular" name="celular" required class="form-control" value="{{ isset($cliente) ? $cliente->celular : '' }}">
            </div>

            <div class="form-group">
                <label for="limite_credito">Limite de crédito:</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">R$</span>
                    </div>
                    <input type="text" id="limite_credito" name="limite_credito" required class="form-control" placeholder="0.00" value="{{ isset($cliente) ? $cliente->limite_credito : '' }}">
                </div>
            </div>

            <div class="form-group text-center">
                <div class="row">
                    <div class="col-md-6">
                        <a href="{{ route('app.home') }}" class="btn btn-danger btn-block">Voltar</a>
                    </div>
                    <div class="col-md-6 mb-2 mb-md-0">
                        <button type="submit" class="btn btn-primary btn-block">{{ isset($cliente) ? 'Atualizar Cliente' : 'Cadastrar Cliente' }}</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
