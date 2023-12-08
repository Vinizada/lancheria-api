@extends('layouts.default')

@section('titulo', 'Produtos')

@section('conteudo')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <h2 class="text-center">Listagem de Produtos</h2>
                <br>
                <a href="{{ route('produto.cadastro') }}" class="btn-verde mb-3 d-block mx-auto">Cadastrar Novo Produto</a>
                <br>

                <div class="row">
                    @foreach ($produtos as $produto)
                        <div class="col-md-6 mb-4">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <div>
                                            <h5 class="font-weight-bold">{{ $produto->nome }}</h5>
                                            <span class="badge badge-secondary">Estoque Atual: {{ $produto->quantidade }}</span>
                                            <span class="badge badge-secondary">Valor Atual do Estoque: R$ {{ $produto->valor_estoque_atual }}</span>
                                        </div>
                                        <div class="d-flex">
                                            <a href="{{ route('produto.editar', ['produto_id' => $produto->id]) }}" class="btn btn-primary mr-2">
                                                <i class="fas fa-pencil-alt"></i>
                                            </a>
                                            <form action="{{ route('produto.deletar', ['produto_id' => $produto->id]) }}" method="POST">
                                                @csrf
                                                @method('GET')
                                                <button type="submit" class="btn btn-danger">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                    <div>
                                        <p class="text-success font-weight-bold mb-0">Preço de Venda: R$ {{ $produto->preco_venda }}</p>
                                        <p class="text-danger font-weight-bold mb-0">Preço de Custo:  {{ isset($produto->preco_custo) ? 'R$' . $produto->preco_custo : 'Cadastre uma compra!' }}</p>
                                        <p class="mb-0">
                                            <span class="text-info">Estoque Mínimo: {{ $produto->estoque_minimo }}</span>
                                        </p>
                                    </div>
                                    <div class="mt-2 text-center">
                                        <a style="width:75%" href="{{ route('estoque.cadastro', ['id' => $produto->id]) }}" class="btn btn-info">
                                            <i class="fas fa-box"></i> Compras
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
