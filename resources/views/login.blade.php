@extends('layouts.principal')

@section('titulo', 'Teste')

@section('conteudo')
    <div class="container-fluid h-100">
        <div class="row h-100">
            <div class="col-md-8 bg-dark text-white d-flex align-items-center justify-content-center">
                <div class="p-5">
                    <h1 class="mb-5">Lancheria Verde Mar - Sistema de gestão</h1>
                    <div class="card mt-5 text-center">
                        <div class="card-body">
                            <div class="text-left p-2">
                                <h2 class="card-title">Sobre o projeto</h2>
                                <p class="card-text text-black-50">
                                    Esse projeto foi criado para o negócio dos meus pais, a lancheria tem mais de 30 anos de existência e até hoje, as vendas e pedidos são controlados no papel e caneta. Assim que meus pais assumiram recentemente o negócio que era da família, senti a necessidade de ajudar a empresa com os meus conhecimentos, e com isso decidi criar um software que facilitará e muito o dia a dia deles.<br><br>
                                    A ideia do software não é somente fazer pedidos e gerenciar o estoque, mas sim, trazer uma inteligência de negócio, com métricas e automações que são utilizadas em sistemas mais robustos e por empresas maiores.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 bg-light d-flex align-items-center justify-content-center">
                <div class="p-5 border rounded">
                    <h2 class="mb-4 text-center">Login</h2>
                    <form action={{ route('site.autenticar') }} method="post">
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
                        <div class="mb-3 form-check">
                            <a href="#" class="form-check-label">Esqueceu sua senha?</a>
                        </div>
                        <button type="submit" class="btn btn-primary btn-lg">Entrar</button>
                    </form>
                    {{ isset($erro) && $erro != '' ? $erro : '' }}
                </div>
            </div>
        </div>
    </div>
@endsection
