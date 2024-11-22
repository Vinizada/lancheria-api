@extends('layouts.principal')

@section('titulo', 'Pedidos')

@push('styles')
    <link rel="stylesheet" href="{{ mix('css/pages/pedidos.css') }}">
@endpush

@section('conteudo')
    <div class="container mt-4">
        <h2 class="text-center mb-4">Pedidos</h2>

        <div class="mb-4">
            <form id="filtroPedidos" method="GET" action="{{ route('pedidos.buscarPedidos') }}">
                <div class="form-row align-items-end">
                    <div class="form-group col-md-2">
                        <label for="pedido_id">ID do Pedido</label>
                        <input type="text" id="pedido_id" name="pedido_id" class="form-control" placeholder="Digite o ID do pedido">
                    </div>
                    <div class="form-group col-md-3">
                        <label for="cliente">Cliente</label>
                        <select id="cliente" name="cliente" class="form-control">
                            <option value="">Selecione um cliente</option>
                            @foreach($clientes as $cliente)
                                <option value="{{ $cliente->id }}">{{ $cliente->nome }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-2">
                        <label for="data_inicio">Data Início</label>
                        <input type="date" id="data_inicio" name="data_inicio" class="form-control">
                    </div>
                    <div class="form-group col-md-4">
                        <button type="submit" class="btn btn-primary btn-block">Buscar</button>
                    </div>
                </div>
            </form>
        </div>

        <div class="table-responsive pedidos-lista-scroll">
            <table class="table table-bordered table-hover">
                <thead>
                <tr>
                    <th><a href="{{ route('pedidos.buscarPedidos', ['ordenar' => 'id']) }}">Pedido ID</a></th>
                    <th><a href="{{ route('pedidos.buscarPedidos', ['ordenar' => 'cliente']) }}">Nome do Cliente</a></th>
                    <th>Forma de Pagamento</th>
                    <th><a href="{{ route('pedidos.buscarPedidos', ['ordenar' => 'valor_total']) }}">Valor Total</a></th>
                    <th>Quantidade Itens</th>
                    <th>Status</th>
                    <th><a href="{{ route('pedidos.buscarPedidos', ['ordenar' => 'data_pedido']) }}">Data do Pedido</a></th>
                    <th>Ações</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($pedidos as $pedido)
                    <tr>
                        <td>{{ $pedido->id }}</td>
                        <td>{{ $pedido->cliente }}</td>
                        <td>{{ $pedido->forma_pagamento }}</td>
                        <td>R$ {{ number_format($pedido->valor_total, 2, ',', '.') }}</td>
                        <td>{{ $pedido->quantidade_itens }}</td>
                        <td>{{ $pedido->status }}</td>
                        <td>{{ \Carbon\Carbon::parse($pedido->data_pedido)->format('d/m/Y H:i') }}</td>
                        <td>
                            <button class="btn btn-info btn-sm" onclick="verDetalhesPedido({{ $pedido->id }})">Ver Detalhes</button>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        <div class="text-center mt-4">
            <a href="{{ route('app.home') }}" class="btn btn-danger">Voltar</a>
        </div>
    </div>

    <div class="modal fade" id="detalhesPedidoModal" tabindex="-1" aria-labelledby="detalhesPedidoModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="detalhesPedidoModalLabel">Detalhes do Pedido</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>Produto</th>
                            <th>Quantidade</th>
                            <th>Preço Unitário</th>
                            <th>Subtotal</th>
                        </tr>
                        </thead>
                        <tbody id="detalhesPedidoTabela">
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function verDetalhesPedido(pedidoId) {
            fetch(`/pedido/${pedidoId}/detalhes`)
                .then(response => response.json())
                .then(data => {
                    const tabela = document.getElementById('detalhesPedidoTabela');
                    tabela.innerHTML = '';

                    data.itens.forEach(item => {
                        const row = `
                        <tr>
                            <td>${item.produto}</td>
                            <td>${item.quantidade}</td>
                            <td>R$ ${item.preco_unitario}</td>
                            <td>R$ ${item.subtotal}</td>
                        </tr>`;
                        tabela.insertAdjacentHTML('beforeend', row);
                    });

                    $('#detalhesPedidoModal').modal('show');
                })
                .catch(error => console.error('Erro ao carregar detalhes do pedido:', error));
        }
    </script>
@endpush
