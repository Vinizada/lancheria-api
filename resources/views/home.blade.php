@extends('layouts.principal')

@section('titulo', 'Home')

@push('styles')
    <link rel="stylesheet" href="{{ mix('css/pages/home.css') }}">
@endpush

@section('conteudo')
    <div id="elemento-home"></div>
    <div class="container-fluid mt-2">
        <div class="row justify-content-center mt-2">
            <div class="container">
                <div class="text-center mb-4">
                    <button id="btnAtualizarIndicadores" class="btn-custom mb-2">Atualizar Indicadores</button>
                    <select id="periodoSelect" class="form-control d-inline-block" style="width: 200px;">
                        <option value="mesAtual" selected>Mês Atual</option>
                        <option value="30">Últimos 30 dias</option>
                        <option value="60">Últimos 60 dias</option>
                        <option value="90">Últimos 90 dias</option>
                    </select>
                </div>

                <div class="card-deck" id="indicadores-container">
                    <div class="card shadow">
                        <div class="card-body text-center">
                            <h5 class="font-weight-bold" style="font-size: 20px;">Total de Vendas</h5>
                            <h6 id="totalVendas" style="font-size: 18px;">R$ 0,00</h6>
                        </div>
                    </div>
                    <div class="card shadow">
                        <div class="card-body text-center">
                            <h5 class="font-weight-bold" style="font-size: 20px;">Lucro %</h5>
                            <h6 id="lucroPercentual" style="font-size: 18px;">0%</h6>
                        </div>
                    </div>
                    <div class="card shadow">
                        <div class="card-body text-center">
                            <h5 class="font-weight-bold" style="font-size: 20px;">Lucro R$</h5>
                            <h6 id="lucroReal" style="font-size: 18px;">R$ 0,00</h6>
                        </div>
                    </div>
                    <div class="card shadow">
                        <div class="card-body text-center">
                            <h5 class="font-weight-bold" style="font-size: 20px;">Pendente de pagamento</h5>
                            <h6 id="pendentePagamento" style="font-size: 18px;">R$ 0,00</h6>
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
                    <a href="{{ route('estoque.cadastro', ['origem' => 'home']) }}" class="btn-custom mb-2">
                        <i class="fas fa-shopping-cart"></i> Cadastrar Compra
                    </a>
                    <button type="button" class="btn-custom mb-2" data-bs-toggle="modal" data-bs-target="#selecionarClienteModal">
                        <i class="fas fa-dollar-sign"></i> Realizar Venda
                    </button>
                    <a href="{{ route('pedidos.buscarPedidos') }}" class="btn-custom mb-2">
                        <i class="fas fa-user"></i> Consultar Pedidos
                    </a>
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
        function atualizarIndicadores(periodo = 'mesAtual') {
            console.log(`Atualizando indicadores para o período: ${periodo}`);

            fetch(`/indicadores/${periodo}`)
                .then(response => {
                    console.log(`Status da resposta: ${response.status}`);
                    if (!response.ok) {
                        throw new Error(`Erro ao buscar indicadores: ${response.statusText}`);
                    }
                    return response.json();
                })
                .then(data => {
                    console.log('Dados recebidos:', data);
                    document.getElementById('totalVendas').innerText = `R$ ${data.totalVendas}`;
                    document.getElementById('lucroPercentual').innerText = `${data.lucroPercentual}%`;
                    document.getElementById('lucroReal').innerText = `R$ ${data.lucroReal}`;
                    document.getElementById('pendentePagamento').innerText = `R$ ${data.pendentePagamento}`;
                })
                .catch(error => console.error('Erro ao atualizar indicadores:', error));
        }

        setInterval(() => {
            const periodo = document.getElementById('periodoSelect').value;
            atualizarIndicadores(periodo);
        }, 30000);

        document.getElementById('btnAtualizarIndicadores').addEventListener('click', () => {
            const periodo = document.getElementById('periodoSelect').value;
            atualizarIndicadores(periodo);
        });

        document.addEventListener('DOMContentLoaded', () => {
            const periodo = document.getElementById('periodoSelect').value;
            atualizarIndicadores(periodo);
        });

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
