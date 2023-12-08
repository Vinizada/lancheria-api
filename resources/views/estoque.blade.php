@extends('layouts.default')

@section('titulo', 'Produtos')

@section('conteudo')
    <div class="container mt-5">
        <h2 class="text-center">Cadastrar compra</h2>

        <form method="POST" action="{{ route('estoque.create') }}" class="mx-auto mt-4 p-4 border rounded">
            @csrf

            <div class="form-group">
                <label for="item">Selecione um Item:</label>
                <select id="item" name="produto_id" required {{ $produtoSelecionado ? 'readonly' : '' }}>
                    <option value="" disabled {{ !$produtoSelecionado ? 'selected' : '' }}>Selecione um item</option>
                    @foreach($produtos as $produto)
                        <option value="{{ $produto->id }}" {{ $produtoSelecionado == $produto->id ? 'selected' : '' }}>{{ $produto->nome }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="quantidade">Quantidade:</label>
                <input type="number" id="quantidade" name="quantidade" required class="form-control">
            </div>

            <div class="form-group">
                <label for="valor_custo_unitario">Valor Custo:</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">R$</span>
                    </div>
                    <input type="text" id="valor_custo_unitario" name="valor_custo_unitario" required class="form-control" placeholder="0,00">
                </div>
            </div>

            <div class="form-group text-center">
                <div class="row">
                    <div class="col-md-6">
                        <a href="{{ route('estoque.listar', ['id' => $produto->id]) }}" class="btn btn-danger btn-block">Voltar</a>
                    </div>
                    <div class="col-md-6 mb-2 mb-md-0">
                        <button type="submit" class="btn btn-primary btn-block">Salvar</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
