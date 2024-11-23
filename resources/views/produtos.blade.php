@extends('layouts.principal')

@section('titulo', 'Produtos')

@push('styles')
    <link rel="stylesheet" href="{{ mix('css/pages/produto.css') }}">
@endpush

@section('conteudo')
    <div class="container-fluid produtos-container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <h2 class="text-center">Listagem de Produtos</h2>
                <br>
                <div class="row">
                    <div class="col-md-6">
                        <a href="{{ route('app.home') }}" class="btn btn-danger btn-block">Voltar</a>
                    </div>
                    <div class="col-md-6">
                        <a href="{{ route('produto.cadastro') }}" class="btn-cadastrar-produto">Cadastrar Novo Produto</a>
                    </div>
                </div>
                <br>

                <div class="produtos-lista-scroll">
                    <div class="produtos-lista">
                        @foreach ($produtos as $produto)
                            <div class="produto-card">
                                <div class="produto-card-body">
                                    <div class="d-flex align-items-center">
                                        <img src="{{ route('produto.imagem', ['produto_id' => $produto->id]) }}" alt="Imagem do Produto" class="produto-imagem">
                                        <div class="produto-info">
                                            <h5 class="produto-nome">{{ $produto->nome }}</h5>
                                            <span class="badge badge-secondary">Estoque Atual: {{ $produto->quantidade }}</span>
                                            <span class="badge badge-secondary">Valor Atual do Estoque: R$ {{ $produto->valor_estoque_atual }}</span>
                                        </div>
                                        <div class="produto-acoes">
                                            <a href="{{ route('produto.editarProduto', ['produto_id' => $produto->id]) }}" class="btn btn-primary btn-acao">
                                                <i class="fas fa-pencil-alt"></i>
                                            </a>
                                            <form action="{{ route('produto.deletar', ['produto_id' => $produto->id]) }}" method="POST" class="form-deletar">
                                                @csrf
                                                @method('GET')
                                                <button type="submit" class="btn btn-danger btn-acao">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="produto-precos">
                                        <p class="preco-venda">Preço de Venda: R$ {{ $produto->preco_venda }}</p>
                                        <p class="preco-custo">Preço de Custo: {{ isset($produto->preco_custo) ? 'R$' . $produto->preco_custo : 'Cadastre uma compra!' }}</p>
                                        <p class="custo-medio">Custo Médio: {{ isset($produto->preco_medio) ? 'R$' . $produto->preco_medio : 'Rotina não executada!' }}</p>
                                    </div>
                                    <div class="produto-compras text-center">
                                        <a href="{{ route('estoque.listarComprasProduto', ['id' => $produto->id]) }}" class="btn btn-info">
                                            <i class="fas fa-box"></i> Compras
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
