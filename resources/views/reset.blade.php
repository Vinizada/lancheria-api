@extends('layouts.default')

@section('titulo', 'Redefinir Senha')

@push('styles')
    <link rel="stylesheet" href="{{ mix('css/pages/login.css') }}">
@endpush

@section('conteudo')
    <div class="container">
        <h2>Redefinir Senha</h2>

        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('password.update') }}">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">
            <div class="form-group">
                <label for="email">E-mail</label>
                <input id="email" type="email" name="email" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="password">Nova Senha</label>
                <input id="password" type="password" name="password" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="password_confirmation">Confirmar Nova Senha</label>
                <input id="password_confirmation" type="password" name="password_confirmation" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Redefinir Senha</button>
        </form>
    </div>
@endsection
