@extends('layouts.default')

@section('titulo', 'Produtos')

@section('conteudo')
    <h1>Cadastro de Produto</h1>

    <form method="POST" action="{{ route('produto.create') }}">
        @csrf

        <div>
            <label for="nome">Nome:</label>
            <input type="text" id="nome" name="nome" required>
        </div>

        <div>
            <label for="preco_venda">Preço de Venda:</label>
            <input type="text" id="preco_venda" name="preco_venda" required>
        </div>

        <div>
            <label for="preco_custo">Preço de Custo:</label>
            <input type="text" id="preco_custo" name="preco_custo" required>
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
