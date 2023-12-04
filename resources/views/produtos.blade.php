@extends('layouts.default')

@section('titulo', 'Produtos')

@section('conteudo')
    <h1>Listagem de Produtos</h1>

    <table>
        <thead>
        <tr>
            <th>Nome</th>
            <th>Preço</th>
            <th>Estoque Mínimo</th>
            <th>Ativo</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($produtos as $produto)
            <tr>
                <td>{{ $produto->nome }}</td>
                <td>{{ $produto->preco }}</td>
                <td>{{ $produto->estoque_minimo }}</td>
                <td>
                    <!-- Componente Toggle para indicar Ativo/Inativo -->
                    <label class="switch">
                        <input type="checkbox" {{ $produto->ativo ? 'checked' : '' }}>
                        <span class="slider round"></span>
                    </label>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection
