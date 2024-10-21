@extends('layouts.default')

@section('titulo', 'Cadastro de Produtos')

@section('conteudo')
    <div class="container mt-5">
        <h2 class="text-center">Cadastro de Produto</h2>

        <form method="POST" enctype="multipart/form-data" action="{{ isset($produto) ? route('produto.editar', ['id' => $produto->id]) : route('produto.create') }}" class="mx-auto mt-4 p-4 border rounded">
            @csrf

            <div class="form-group">
                <label for="nome">Nome:</label>
                <input type="text" id="nome" name="nome" required class="form-control" value="{{ isset($produto) ? $produto->nome : '' }}">
            </div>

            <div class="form-group">
                <label for="estoque_minimo">Estoque Mínimo:</label>
                <input type="text" id="estoque_minimo" name="estoque_minimo" required class="form-control" value="{{ isset($produto) ? $produto->estoque_minimo : '' }}">
            </div>

            <div class="form-group">
                <label for="preco_venda">Preço de Venda:</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">R$</span>
                    </div>
                    <input type="text" id="preco_venda" name="preco_venda" required class="form-control" placeholder="0.00" value="{{ isset($produto) ? $produto->preco_venda : '' }}">
                </div>
            </div>

            <div class="form-group">
                <label for="imagem">Imagem do Produto:</label>
                <input type="file" id="imagem" name="imagem" class="form-control-file" accept="image/*">
            </div>

            <div class="form-group text-center">
                <div class="row">
                    <div class="col-md-6">
                        <a href="{{ route('produto.listar') }}" class="btn btn-danger btn-block">Voltar</a>
                    </div>
                    <div class="col-md-6 mb-2 mb-md-0">
                        <button type="submit" class="btn btn-primary btn-block">{{ isset($produto) ? 'Atualizar Produto' : 'Cadastrar Produto' }}</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
