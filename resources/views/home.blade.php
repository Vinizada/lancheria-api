@extends('layouts.principal')

@section('titulo', 'Home')

@push('styles')
    <link rel="stylesheet" href="{{ mix('css/pages/home.css') }}">
@endpush

@section('conteudo')
    <div id="elemento-home"></div>
    <div class="container-fluid mt-2">
        <div class="row justify-content-center mt-2">
            <div class="col-md-12 text-center">
                <h3 class="font-weight-bold mb-1">Indicadores</h3>
                <br>
                <div class="card-deck" id="indicadores-container">
                    <div class="card shadow">
                        <div class="card-body text-center">
                            <h5 class="font-weight-bold" style="font-size: 20px;">Total de Vendas</h5>
                            <h6 id="total-vendas" style="font-size: 18px;">R$ 500,00</h6>
                        </div>
                    </div>
                    <div class="card shadow">
                        <div class="card-body text-center">
                            <h5 class="font-weight-bold" style="font-size: 20px;">Lucro %</h5>
                            <h6 id="lucro-percentual" style="font-size: 18px;">25%</h6>
                        </div>
                    </div>
                    <div class="card shadow">
                        <div class="card-body text-center">
                            <h5 class="font-weight-bold" style="font-size: 20px;">Lucro R$</h5>
                            <h6 id="lucro-valor" style="font-size: 18px;">R$ 150,00</h6>
                        </div>
                    </div>
                    <div class="card shadow">
                        <div class="card-body text-center">
                            <h5 class="font-weight-bold" style="font-size: 20px;">Pendente de pagamento</h5>
                            <h6 id="pendente-pagamento" style="font-size: 18px;">R$ 200,00</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row justify-content-center mt-4">
            <div class="col-md-12 text-center">
                <h3 class="font-weight-bold mb-1">Ações Rápidas</h3>
                <br>
                <div class="action-buttons">
                    <a href="{{ route('produto.listar') }}" class="btn-custom mb-2">
                        <i class="fas fa-box"></i> Cadastro de Produtos
                    </a>
                    <a href="{{ route('estoque.cadastro') }}" class="btn-custom mb-2">
                        <i class="fas fa-shopping-cart"></i> Cadastrar Compra
                    </a>
                    <button type="button" class="btn-custom mb-2" data-bs-toggle="modal" data-bs-target="#selecionarClienteModal">
                        <i class="fas fa-dollar-sign"></i> Realizar Venda
                    </button>
                    <a href="{{ route('cliente.cadastro') }}" class="btn-custom mb-2">
                        <i class="fas fa-user"></i> Cadastro de Clientes
                    </a>
                    <a href="{{ route('fornecedor.cadastro') }}" class="btn-custom mb-2">
                        <i class="fas fa-truck"></i> Cadastro de Fornecedores
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de Seleção de Cliente -->
    <div class="modal fade" id="selecionarClienteModal" tabindex="-1" role="dialog" aria-labelledby="selecionarClienteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="selecionarClienteModalLabel">Selecione um Cliente</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">Fechar</button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="buscar-cliente">Buscar Cliente:</label>
                        <input type="text" id="buscar-cliente" class="form-control" placeholder="Digite o nome do cliente..." onkeyup="filtrarClientes()">
                    </div>
                    <div class="row mt-4" id="lista-clientes">
                        @foreach($clientes as $cliente)
                            <div class="col-md-12 cliente-item" data-nome="{{ strtolower($cliente->nome) }}" data-cliente-id="{{ $cliente->id }}">
                                <div class="card mb-4 shadow-sm card-produto" style="cursor: pointer;">
                                    <div class="card-body text-center">
                                        <h5 class="card-title">{{ $cliente->nome }}</h5>
                                        <p class="card-text">Telefone: {{ $cliente->telefone ?? 'N/A' }}</p>
                                        <p class="card-text">Email: {{ $cliente->email ?? 'N/A' }}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>\
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function atualizarIndicadores() {
            fetch('/home/indicadores')
                .then(response => response.json())
                .then(data => {
                    document.getElementById('total-vendas').innerText = `R$ ${data.total_vendas}`;
                    document.getElementById('lucro-percentual').innerText = `${data.lucro_percentual}%`;
                    document.getElementById('lucro-valor').innerText = `R$ ${data.lucro_valor}`;
                    document.getElementById('pendente-pagamento').innerText = `R$ ${data.pendente_pagamento}`;
                })
                .catch(error => console.error('Erro ao atualizar indicadores:', error));
        }

        setInterval(atualizarIndicadores, 30000);

        function redirecionarParaPedido(clienteId) {
            if (clienteId) {
                window.location.href = `/pedido/${clienteId}`;
            } else {
                alert('Por favor, selecione um cliente antes de continuar.');
            }
        }

        function filtrarClientes() {
            const input = document.getElementById('buscar-cliente').value.toLowerCase();
            const clientes = document.querySelectorAll('.cliente-item');

            clientes.forEach(cliente => {
                const nome = cliente.getAttribute('data-nome');
                cliente.style.display = nome.includes(input) ? '' : 'none';
            });
        }

        document.addEventListener('DOMContentLoaded', () => {
            atualizarIndicadores();

            document.querySelectorAll('.cliente-item').forEach(item => {
                item.addEventListener('click', () => {
                    const clienteId = item.getAttribute('data-cliente-id');
                    redirecionarParaPedido(clienteId);
                });
            });
        });
    </script>
@endpush
