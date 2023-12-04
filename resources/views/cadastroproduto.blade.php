@extends('layouts.default')

@section('titulo', 'Produtos')

@section('conteudo')
    <h1>Cadastro de Produto</h1>

    <form method="POST" action="{{ route('produto.create') }}">
        @csrf <!-- Adiciona um token CSRF -->

        <div>
            <label for="nome">Nome:</label>
            <input type="text" id="nome" name="nome" required>
        </div>

        <div>
            <label for="preco">Preço:</label>
            <input type="text" id="preco" name="preco" required>
        </div>

        <div>
            <label for="estoque_minimo">Estoque Mínimo:</label>
            <input type="text" id="estoque_minimo" name="estoque_minimo" required>
        </div>

        <div>
            <label for="ativo">Ativo (0 - Inativo, 1 - Ativo):</label>
            <input type="number" id="ativo" name="ativo" min="0" max="1" required>
        </div>

        <div>
            <button type="submit">Cadastrar Produto</button>
        </div>
    </form>
@endsection
