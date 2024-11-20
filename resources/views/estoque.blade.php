@extends('layouts.principal')

@section('titulo', 'Produtos')

@section('conteudo')
    <script src="{{ asset('js/estoqueView.js') }}"></script>
    <div class="container mt-5">
        <h2 class="text-center">Cadastrar compra</h2>

        <form method="POST" action="{{ route('estoque.create') }}" class="mx-auto mt-4 p-4 border rounded">
            @csrf

            <div class="form-group">
                <label for="item">Selecione um Item:</label>
                <select id="item" name="produto_id" class="form-control" required>
                    <option value="" disabled selected>Selecione um item</option>
                    @foreach($produtos as $produto)
                        <option value="{{ $produto->id }}"
                                data-nome="{{ $produto->nome }}"
                                data-preco="{{ number_format($produto->preco_venda, 2, ',', '.') }}"
                                data-codigo="{{ $produto->codigo }}"
                                data-imagem="{{ $produto->imagem }}">
                            {{ $produto->nome }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div id="produto-selecionado-card" class="card card-produto mt-4" style="display: none;">
                <div class="card-body">
                    <div class="d-flex">
                        <img id="produto-selecionado-imagem" src="" alt="Imagem do Produto" class="img-thumbnail" style="width: 100px; height: 100px; object-fit: cover;">
                        <div class="ml-4">
                            <h5 id="produto-selecionado-nome"></h5>
                            <p><strong>Código:</strong> <span id="produto-selecionado-codigo"></span></p>
                            <p><strong>Preço de Venda:</strong> R$ <span id="produto-selecionado-preco"></span></p>
                        </div>
                    </div>
                </div>
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

            <div class="form-group">
                <label for="validade">Data de Validade:</label>
                <input type="date" id="validade" name="validade" class="form-control" required>
            </div>

            <div class="form-group text-center">
                <div class="row">
                    <div class="col-md-6">
                        <a href="{{ route('estoque.listarComprasProduto', ['id' => $produto->id]) }}" class="btn btn-danger btn-block">Voltar</a>
                    </div>
                    <div class="col-md-6 mb-2 mb-md-0">
                        <button type="submit" class="btn btn-primary btn-block">Salvar</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
