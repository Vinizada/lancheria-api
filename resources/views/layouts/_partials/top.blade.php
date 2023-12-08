<header class="bg-success text-white p-3">
    <div class="d-flex justify-content-between align-items-center">

        <a href="{{ route('app.home') }}" class="text-decoration-none">
            <h1 class="m-0 text-center">Verde Mar - Gestão</h1>
        </a>

        <div>
            <span style="margin:5px; color:#ffffff">Bem-vindo, {{ $nomeUsuario }}</span>
            <a href="{{ route('app.sair') }}" class="btn btn-light">
                <i class="fas fa-sign-out-alt" aria-hidden="true"></i> Sair
            </a>
        </div>
    </div>
</header>
<br/>
