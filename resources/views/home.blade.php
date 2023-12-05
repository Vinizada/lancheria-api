@extends('layouts.default')

@section('titulo', 'Teste')

@section('conteudo')
    <br>
    <div style="text-align: right;">
        <p><strong>Bem-vindo, {{ $nomeUsuario }}</strong></p>
    </div>
    <div style="text-align: center; margin-top: 50px;">
        <a href="{{ route('produto.listar') }}" style="text-decoration: none;">
            <button style="margin-bottom: 10px;">Cadastro de Produtos</button>
        </a>
        <a href="{{ route('estoque.cadastro') }}" style="text-decoration: none;">
            <button style="margin-bottom: 10px;">Cadastrar Estoque</button>
        </a>
        <a href="{{ route('pedido.envia') }}" style="text-decoration: none;">
            <button style="margin-bottom: 10px;">Fazer Pedido</button>
        </a>
    </div>
@endsection
