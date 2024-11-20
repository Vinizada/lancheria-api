@push('styles')
    <link rel="stylesheet" href="{{ mix('css/pages/top.css') }}">
@endpush

<header class="header-top p-3">
    <div class="d-flex justify-content-between align-items-center">
        <a href="{{ route('app.home') }}" class="d-flex align-items-center text-decoration-none">
            <img src="{{ asset('logo branco.png') }}" alt="EasyCoffe Logo" class="logo-easycoffe">
        </a>

        <div class="d-flex align-items-center">
            <span class="welcome-text">Bem-vindo, {{ $nomeUsuario }}</span>
            <a href="{{ route('app.configuracoes') }}" class="btn btn-light btn-icon mx-2">
                <i class="fas fa-cog" aria-hidden="true"></i> Configurações
            </a>
            <a href="{{ route('app.sair') }}" class="btn btn-light btn-icon">
                <i class="fas fa-sign-out-alt" aria-hidden="true"></i> Sair
            </a>
        </div>
    </div>
</header>
<br/>
