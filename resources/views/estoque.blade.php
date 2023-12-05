@extends('layouts.default')

@section('titulo', 'Produtos')

@section('conteudo')
<h1>Adicionar ao Estoque</h1>

<form method="POST" action="{{ route('estoque.create') }}">
    @csrf

    <div>
        <label for="item">Selecione um Item:</label>
        <select id="item" name="produto_id" required {{ $produtoSelecionado ? 'readonly' : '' }}>
            <option value="" disabled {{ !$produtoSelecionado ? 'selected' : '' }}>Selecione um item</option>
            @foreach($produtos as $produto)
                <option value="{{ $produto->id }}" {{ $produtoSelecionado == $produto->id ? 'selected' : '' }}>{{ $produto->nome }}</option>
            @endforeach
        </select>
    </div>

    <div>
        <label for="quantidade">Quantidade:</label>
        <input type="number" id="quantidade" name="quantidade" required>
    </div>

    <div>
        <button type="submit">Salvar</button>
    </div>
</form>
@endsection
