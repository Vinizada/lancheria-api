@extends('layouts.principal')

@section('titulo', 'Produtos')

@push('styles')
    <link rel="stylesheet" href="{{ mix('css/pages/compras.css') }}">
@endpush

@section('conteudo')
    <div class="container mt-4">
        <div class="row">
            <div class="col-md-10 offset-md-1">
                <h2 class="text-center mb-4">Compras do produto {{ $produto->nome }}</h2>

                <div class="text-center mb-3">
                    <a href="{{ route('estoque.cadastro', ['origem' => 'produto']) }}" class="btn-verde mb-3 d-block mx-auto">Cadastrar Compra</a>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>Quantidade</th>
                            <th>Valor Unitário</th>
                            <th>Valor Total</th>
                            <th>Data de Validade</th>
                            <th>Data da Movimentação</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($compras as $compra)
                            <tr>
                                <td>{{ $compra->quantidade }}</td>
                                <td>R$ {{ $compra->valor_unitario }}</td>
                                <td>R$ {{ $compra->valor_total }}</td>
                                <td>{{ \Carbon\Carbon::parse($compra->data_validade)->format('d/m/Y') }}</td>
                                <td>{{ \Carbon\Carbon::parse($compra->data_movimentacao)->format('d/m/Y H:i') }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="text-center mt-4">
                    <a href="{{ route('produto.listar') }}" class="btn btn-danger btn-block">Voltar</a>
                </div>
            </div>
        </div>
    </div>
@endsection
