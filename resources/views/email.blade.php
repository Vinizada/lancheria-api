@extends('layouts.default')

@section('titulo', 'Esqueceu a senha')

@push('styles')
    <link rel="stylesheet" href="{{ mix('css/pages/login.css') }}">
@endpush

@section('conteudo')
    <div class="container">
        <h2>Recuperar Senha</h2>

        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
            <a href="{{ route('site.login') }}" class="btn btn-success mt-3">Voltar ao Login</a>
        @endif

        @if ($errors->has('email'))
            <div class="alert alert-danger">
                {{ $errors->first('email') }}
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}">
            @csrf
            <div class="form-group">
                <label for="email">E-mail</label>
                <input id="email" type="email" name="email" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Enviar Link</button>
        </form>
    </div>
@endsection
