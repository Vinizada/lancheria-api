@extends('layouts.default')

@section('titulo', 'Login')

@push('styles')
    <link rel="stylesheet" href="{{ mix('css/pages/login.css') }}">
@endpush

@section('conteudo')
    <div class="container-principal">
        <div class="left-section">
            <div class="content-wrapper text-center">
                <img src="{{ asset('logo branco.png') }}" alt="Logo EasyCoffe" class="logo img-fluid mb-4">
                <h1>EasyCafe - Sistema de Gestão</h1>
                <p>Esse projeto foi criado para facilitar a administração do negócio com inteligência de dados e gestão simplificada.</p>
            </div>
        </div>

        <div class="right-section">
            <div class="login-container">
                <h2 class="text-center mb-4">Login</h2>

                <form action="{{ route('site.autenticar') }}" method="post">
                    @csrf

                    <div class="mb-3">
                        <label for="inputEmail" class="form-label">E-mail</label>
                        <input name="usuario" value="{{ old('usuario') }}" type="text" placeholder="E-mail" class="form-control form-control-lg">
                        {{ $errors->has('usuario') ? $errors->first('usuario') : '' }}
                    </div>

                    <div class="mb-3">
                        <label for="inputPassword" class="form-label">Senha</label>
                        <input name="senha" type="password" placeholder="Senha" class="form-control form-control-lg">
                        {{ $errors->has('senha') ? $errors->first('senha') : '' }}
                    </div>

                    <div class="mb-3 text-right">
                        <a href="{{ route('password.request') }}" class="text-decoration-none">Esqueceu sua senha?</a>
                    </div>

                    <button type="submit" class="btn btn-primary btn-lg btn-block enter-button">Entrar</button>
                </form>

                {{ isset($erro) && $erro != '' ? $erro : '' }}
            </div>
        </div>
    </div>
@endsection
