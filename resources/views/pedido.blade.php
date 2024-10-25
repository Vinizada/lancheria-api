@extends('layouts.default')

@section('titulo', 'Realizar Pedido')

@section('conteudo')
    <div class="container mt-5">
        <h2 class="text-center">Realizar Pedido</h2>

        <form method="POST" action="{{route('pedido.create')}}" class="mx-auto mt-4 p-4 border rounded">
            @csrf

            <div class="form-group">
                <label for="cliente">Selecione um Cliente:</label>
                <select id="cliente" name="cliente_id">
                    <option value="">Selecione um Cliente</option>
                    @foreach($clientes as $cliente)
                        <option value="{{ $cliente->id }}">{{ $cliente->nome }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="forma-pagamento">Selecione a forma de pagamento:</label>
                <select id="forma-pagamento" name="forma_pagamento_id">
                    <option value="">Selecione a forma de pagamento</option>
                    @foreach($metodosDePagamento as $metodo)
                        <option value="{{ $metodo->id }}">{{ $metodo->metodo }}</option>
                    @endforeach
                </select>
            </div>
            <div class="container">
                <div class="form-group">
                    <label for="buscar-produto">Buscar Produto:</label>
                    <input type="text" id="buscar-produto" class="form-control" placeholder="Digite o nome do produto...">
                </div>
                <div class="row">
                    @foreach($produtos as $produto)
                        <div class="col-md-4">
                            <div class="card mb-4 shadow-sm">
                                <div class="card-body text-center">
                                    <h5 class="card-title">{{ $produto->nome }}</h5>
                                    <p class="card-text">Preço: R$ {{ number_format($produto->preco_venda, 2, ',', '.') }}</p>
                                    <p class="card-text">Estoque: {{ $produto->quantidade ?? 0 }}</p>
                                    <div class="d-flex justify-content-center align-items-center">
                                        <button class="btn btn-danger btn-sm" id="decrementar-{{ $produto->id }}" type="button" disabled>-</button>
                                        <input type="text" class="form-control text-center mx-2 w-25" id="quantidade-{{ $produto->id }}" value="0" readonly>
                                        <button class="btn btn-success btn-sm" id="incrementar-{{ $produto->id }}" type="button">+</button>
                                    </div>
                                    <input type="hidden" name="produto_id[]" value="{{ $produto->id }}">
                                    <input type="hidden" id="estoque-{{ $produto->id }}" value="{{ $produto->quantidade ?? 0 }}">
                                    <input type="hidden" id="vende-sem-estoque-{{ $produto->id }}" value="{{ $produto->vende_sem_estoque ? 'true' : 'false' }}">
                                    <input type="hidden" id="preco-{{ $produto->id }}" value="{{ $produto->preco_venda }}">
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="form-group text-center">
                <div class="row">
                    <div class="col-md-6">
                        <a href="{{ route('app.home') }}" class="btn btn-danger btn-block">Voltar</a>
                    </div>
                    <div class="col-md-6 mb-2 mb-md-0">
                        <button type="submit" class="btn btn-primary btn-block">Enviar Pedido</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('js/pedido.js') }}"></script>
@endpush
