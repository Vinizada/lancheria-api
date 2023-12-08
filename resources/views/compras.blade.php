@extends('layouts.default')

@section('titulo', 'Produtos')

@section('conteudo')
    <div class="container mt-4">
        <div class="row">
            <div class="col-md-10 offset-md-1">
                <!-- Título -->
                <h2 class="text-center mb-4">Compras do produto {{ $produto->nome }}</h2>

                <!-- Botão "Cadastrar Compra" -->
                <div class="text-center mb-3">
                    <a href="{{ route('estoque.cadastro', ['id' => $produto->id]) }}" class="btn-verde mb-3 d-block mx-auto">Cadastrar Compra</a>
                </div>

                <!-- Tabela de compras -->
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>Quantidade</th>
                            <th>Valor Unitário</th>
                            <th>Valor Total</th>
                            <th>Data da Movimentação</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($compras as $compra)
                            <tr>
                                <td>{{ $compra->quantidade }}</td>
                                <td>R$ {{ $compra->valor_unitario }}</td>
                                <td>R$ {{ $compra->valor_total }}</td>
                                <td>{{ \Carbon\Carbon::parse($compra->data_movimentacao)->format('d/m/Y H:i') }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Botão "Voltar" -->
                <div class="text-center mt-4">
                    <a href="{{ route('produto.listar') }}" class="btn btn-danger btn-block">Voltar</a>
                </div>
            </div>
        </div>
    </div>
@endsection
