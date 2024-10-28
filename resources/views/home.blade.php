@extends('layouts.default')

@section('titulo', 'Home')

@section('conteudo')
    <div id="elemento-home"></div>
    <div class="container-fluid mt-2">
        <div class="row justify-content-center mt-2">
            <div class="col-md-12 text-center">
                <h3 class="font-weight-bold mb-1">Indicadores</h3>
                <br>
                <div class="card-deck">
                    <div class="card shadow">
                        <div class="card-body text-center">
                            <h5 class="font-weight-bold" style="font-size: 20px;">Total de Vendas</h5>
                            <h6 style="font-size: 18px;">R$ 500,00</h6>
                        </div>
                    </div>
                    <div class="card shadow">
                        <div class="card-body text-center">
                            <h5 class="font-weight-bold" style="font-size: 20px;">Lucro %</h5>
                            <h6 style="font-size: 18px;">25%</h6>
                        </div>
                    </div>
                    <div class="card shadow">
                        <div class="card-body text-center">
                            <h5 class="font-weight-bold" style="font-size: 20px;">Lucro R$</h5>
                            <h6 style="font-size: 18px;">R$ 150,00</h6>
                        </div>
                    </div>
                    <div class="card shadow">
                        <div class="card-body text-center">
                            <h5 class="font-weight-bold" style="font-size: 20px;">Pendente de pagamento</h5>
                            <h6 style="font-size: 18px;">R$ 200,00</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row justify-content-center mt-4">
            <div class="col-md-6 text-center">
                <h3 class="font-weight-bold mb-1">Ações Rápidas</h3>
                <br>
                <a href="{{ route('produto.listar') }}" class="btn-verde btn-lg btn-block mb-2">Cadastro de Produtos</a>
                <a href="{{ route('estoque.cadastro') }}" id="link-compra" class="btn-verde btn-lg btn-block mb-2">Cadastrar Compra</a>
                <button type="button" id="link-venda" class="btn-verde btn-lg btn-block mb-2" data-bs-toggle="modal" data-bs-target="#selecionarClienteModal">Realizar Venda</button>
                <a href="{{ route('cliente.cadastro') }}" id="link-cliente" class="btn-verde btn-lg btn-block mb-2">Cadastro de Clientes</a>
                <a href="{{ route('fornecedor.cadastro') }}" id="link-fornecedor" class="btn-verde btn-lg btn-block mb-2">Cadastro de Fornecedores</a>
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
                            <div class="col-md-12 cliente-item" data-nome="{{ strtolower($cliente->nome) }}">
                                <div class="card mb-4 shadow-sm card-produto" onclick="redirecionarParaPedido({{ $cliente->id }})" style="cursor: pointer;">
                                    <div class="card-body text-center">
                                        <h5 class="card-title">{{ $cliente->nome }}</h5>
                                        <p class="card-text">Telefone: {{ $cliente->telefone ?? 'N/A' }}</p>
                                        <p class="card-text">Email: {{ $cliente->email ?? 'N/A' }}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function redirecionarParaPedido(clienteId) {
            if (clienteId) {
                window.location.href = `{{ url('pedido') }}/${clienteId}`;
            } else {
                alert('Por favor, selecione um cliente antes de continuar.');
            }
        }

        function filtrarClientes() {
            const input = document.getElementById('buscar-cliente').value.toLowerCase();
            const clientes = document.querySelectorAll('.cliente-item');

            clientes.forEach(cliente => {
                const nome = cliente.getAttribute('data-nome');
                if (nome.includes(input)) {
                    cliente.style.display = '';
                } else {
                    cliente.style.display = 'none';
                }
            });
        }
    </script>
@endpush
