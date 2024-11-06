@extends('layouts.principal')

@section('titulo', 'Realizar Pedido')

@section('conteudo')
    <div class="container mt-3" style="max-width: 1200px; height: 100vh; overflow: hidden;">
        <!-- Cabeçalho: Botão Voltar, Nome do Cliente e Total -->
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div class="cliente-info d-flex align-items-center" style="margin-left: 50px;">
                <a href="{{ route('app.home') }}" class="btn btn-danger mr-2">X</a>
                @if(isset($clienteSelecionado))
                    <div>
                        <h5 class="mb-0" style="cursor: pointer;" onclick="toggleClienteInfo()">
                            {{ $clienteSelecionado->nome }}
                        </h5>
                        <div id="cliente-info" class="d-none p-2 border rounded bg-light">
                            <p><strong>Telefone:</strong> {{ $clienteSelecionado->celular ?? 'N/A' }}</p>
                            <p><strong>Email:</strong> {{ $clienteSelecionado->email ?? 'N/A' }}</p>
                            <p><strong>Limite de Crédito:</strong> R$ {{ number_format($clienteSelecionado->limite_credito, 2, ',', '.') }}</p>
                        </div>
                    </div>
                @endif
            </div>
            <div class="forma-pagamento d-flex align-items-center" style="margin-right: 50px;">
                <label for="forma-pagamento" class="mr-2">Forma de Pagamento:</label>
                <select id="forma-pagamento" name="forma_pagamento_id" class="form-control" style="max-width: 200px;" onchange="habilitarProdutos()" {{ isset($clienteSelecionado) ? '' : 'disabled' }}>
                    <option value="">Selecione</option>
                    @foreach($metodosDePagamento as $metodo)
                        <option value="{{ $metodo->id }}">{{ $metodo->metodo }}</option>
                    @endforeach
                </select>
                <h5 class="ml-3"><strong>R$ </strong><span id="valor-total">0,00</span></h5>
            </div>
        </div>

        <!-- Título Centralizado -->
        <h4 class="text-center mb-4">Realizar Pedido</h4>

        <!-- Formulário para Realizar Pedido -->
        <form method="POST" action="{{ route('pedido.create') }}" class="mt-2" id="form-pedido">
            @csrf

            <input type="hidden" name="cliente_id" value="{{ $clienteSelecionado->id ?? '' }}" id="cliente-id">
            <input type="hidden" name="forma_pagamento_id" id="forma-pagamento-id">
            <input type="hidden" name="valor_total" id="valor-total-input" value="0">

            <!-- Campo de Busca de Produtos Centralizado e com largura máxima -->
            <div class="form-group">
                <label for="buscar-produto" class="d-block text-center">Buscar Produto:</label>
                <input type="text" id="buscar-produto" class="form-control mx-auto" placeholder="Digite o nome do produto..." style="max-width: 600px;">
            </div>

            <!-- Lista de Produtos com Scroll Interno -->
            <div class="overflow-auto" style="max-height: 400px;">
                <div class="row" id="produtos-container">
                    @foreach($produtos as $produto)
                        <div class="col-12">
                            <div class="card mb-3 shadow-sm d-flex flex-row align-items-center" style="height: 120px;">
                                <img src="{{ route('produto.imagem', ['produto_id' => $produto->id]) }}" alt="Imagem do Produto" class="img-fluid" style="width: 120px; height: 100%; object-fit: cover; border-radius: 5px;">
                                <div class="card-body d-flex flex-row align-items-center" style="flex: 1;">
                                    <div class="info-produto d-flex flex-column justify-content-between mr-3">
                                        <h5 class="card-title">{{ $produto->nome }}</h5>
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-dollar-sign mr-1"></i>
                                            <span>{{ number_format($produto->preco_venda, 2, ',', '.') }}</span>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-box mr-1"></i>
                                            <span>{{ $produto->quantidade ?? 0 }}</span>
                                        </div>
                                    </div>
                                    <div class="ml-auto d-flex align-items-center">
                                        <button class="btn btn-danger btn-sm" id="decrementar-{{ $produto->id }}" type="button" disabled>-</button>
                                        <input type="text" class="form-control text-center mx-2 w-25" id="quantidade-{{ $produto->id }}" value="0" readonly>
                                        <button class="btn btn-success btn-sm" id="incrementar-{{ $produto->id }}" type="button" disabled>+</button>
                                    </div>
                                </div>
                                <input type="hidden" id="estoque-{{ $produto->id }}" value="{{ $produto->quantidade ?? 0 }}">
                                <input type="hidden" id="vende-sem-estoque-{{ $produto->id }}" value="{{ $produto->vende_sem_estoque ? 'true' : 'false' }}">
                                <input type="hidden" id="preco-{{ $produto->id }}" value="{{ $produto->preco_venda }}">
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Botão Enviar Pedido -->
            <div class="form-group mt-4">
                <button type="submit" class="btn btn-primary btn-block" id="enviar-pedido" disabled>Enviar Pedido</button>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('js/pedido.js') }}"></script>
    <script>
        function toggleClienteInfo() {
            const infoDiv = document.getElementById('cliente-info');
            infoDiv.classList.toggle('d-none');
        }
    </script>
@endpush
