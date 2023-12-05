@extends('layouts.default')

@section('titulo', 'Produtos')

@section('conteudo')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <h1 class="text-center">Listagem de Produtos</h1>

                <a href="{{ route('produto.cadastro') }}" class="btn btn-primary mb-3 d-block mx-auto">Cadastrar Novo Produto</a>

                <div class="row">
                    @foreach ($produtos as $produto)
                        <div class="col-md-6 mb-4">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <h5 class="font-weight-bold">{{ $produto->nome }}</h5>
                                        <span class="badge badge-secondary">Estoque Atual: {{ $produto->quantidade }}</span>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <div>
                                            <p class="text-success font-weight-bold mb-0">Preço de Venda: R$ {{ $produto->preco_venda }}</p>
                                            <p class="text-danger font-weight-bold mb-0">Preço de Custo: R$ {{ $produto->preco_custo }}</p>
                                            <p class="mb-0">
                                                <span class="text-info">Estoque Mínimo: {{ $produto->estoque_minimo }}</span>
                                            </p>
                                        </div>
                                        <a href="{{ route('estoque.cadastro', ['id' => $produto->id]) }}" class="btn btn-info">
                                            <i class="fas fa-box mr-1"></i> Controle de Estoque
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
