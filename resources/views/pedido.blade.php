@extends('layouts.principal')

@section('titulo', 'Realizar Pedido')

@push('styles')
    <link rel="stylesheet" href="{{ mix('css/pages/pedido.css') }}">
@endpush

@section('conteudo')
    <div class="container mt-3" style="max-width: 1200px; height: 100vh; overflow: hidden;">
        <div class="header mb-3">
            <div class="cliente-info-header">
                <a href="{{ route('app.home') }}" class="btn-sair mr-3">X</a>
                @if(isset($clienteSelecionado))
                    <h5 class="mb-0">{{ $clienteSelecionado->nome }}</h5>
                @endif
            </div>
            <div class="forma-pagamento">
                <h5 class="ml-3 text-light"><span id="valor-total">0,00</span></h5>
            </div>
        </div>

        <h4 class="text-center mb-4 font-weight-bold">Realizar Pedido</h4>

        <form method="POST" action="{{ route('pedido.create') }}" class="mt-2" id="form-pedido">
            @csrf

            <input type="hidden" name="cliente_id" value="{{ $clienteSelecionado->id ?? '' }}" id="cliente-id">
            <input type="hidden" name="forma_pagamento_id" id="forma-pagamento-id">
            <input type="hidden" name="valor_total" id="valor-total-input" value="0">
            <input type="hidden" name="produtos" id="carrinho-input">

            <div class="form-group">
                <label for="buscar-produto" class="d-block text-center">Buscar Produto:</label>
                <input type="text" id="buscar-produto" class="form-control mx-auto" placeholder="Digite o nome do produto..." style="max-width: 600px;">
            </div>

            <div class="overflow-auto" id="produtos-container">
                @foreach($produtos as $produto)
                    <div class="col-12 mb-2">
                        <div class="card mb-3 shadow-sm d-flex flex-row align-items-center" style="height: 120px; border-radius: 10px;">
                            <img src="{{ route('produto.imagem', ['produto_id' => $produto->id]) }}" alt="Imagem do Produto" class="img-fluid" style="width: 100px; height: 100%; object-fit: cover; border-radius: 10px 0 0 10px;">
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

            <div class="form-group mt-4">
                <button type="submit" class="btn btn-primary btn-block" id="enviar-pedido" disabled>Enviar Pedido</button>
            </div>
        </form>
    </div>

    <!-- Modal de Sucesso -->
    <div class="modal fade" id="modalSucesso" tabindex="-1" role="dialog" aria-labelledby="modalSucessoLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalSucessoLabel">Sucesso</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-center">
                    Pedido enviado com sucesso!
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" onclick="redirectHome()">Ok</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="{{ mix('js/pedido.js') }}"></script>
    <script>
        function toggleClienteInfo() {
            const infoDiv = document.getElementById('cliente-info');
            infoDiv.classList.toggle('d-none');
        }

        function redirectHome() {
            window.location.href = "{{ route('app.home') }}";
        }

        @if(session('success'))
        $(document).ready(function() {
            $('#modalSucesso').modal('show');
        });
        @endif
    </script>
@endpush
