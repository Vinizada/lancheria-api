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
                <a href="{{ route('estoque.cadastro') }}" id="link-venda" class="btn-verde btn-lg btn-block mb-2">Realizar Venda</a>
            </div>
        </div>
    </div>
@endsection
