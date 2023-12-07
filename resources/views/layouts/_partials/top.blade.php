<header class="bg-success text-white p-3">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h1 class="m-0">Verde Mar - Gestão</h1>
        </div>

        <div>
            <span>Bem-vindo, {{ $nomeUsuario }}</span>
            <a href="{{ route('app.sair') }}" class="btn btn-light">
                <i class="fas fa-sign-out-alt" aria-hidden="true"></i> Logout
            </a>
        </div>
    </div>
</header>
