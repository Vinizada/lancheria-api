@extends('layouts.default')

@include('layouts._partials.top')
@section('conteudo')
    <div class="main-container">
        @yield('conteudo')
    </div>
@endsection
