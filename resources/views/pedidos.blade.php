@extends('layouts.principal')

@section('titulo', 'Pedidos')

@section('conteudo')

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
    </script>
@endpush
