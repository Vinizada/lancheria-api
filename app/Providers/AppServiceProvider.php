<?php

namespace App\Providers;

use App\Repositories\Contracts\AcessoRepository;
use App\Repositories\Contracts\ClienteRepository;
use App\Repositories\Contracts\ColaboradorRepository;
use App\Repositories\Contracts\EstoqueRepository;
use App\Repositories\Contracts\FornecedorRepository;
use App\Repositories\Contracts\MetodoPagamentoRepository;
use App\Repositories\Contracts\MovimentacaoEstoqueRepository;
use App\Repositories\Contracts\PedidoRepository;
use App\Repositories\Contracts\PerfilAcessosRepository;
use App\Repositories\Contracts\PerfilRepository;
use App\Repositories\Contracts\ProdutoRepository;
use App\Repositories\Core\CoreAcessoRepository;
use App\Repositories\Core\CoreClienteRepository;
use App\Repositories\Core\CoreColaboradorRepository;
use App\Repositories\Core\CoreEstoqueRepository;
use App\Repositories\Core\CoreFornecedorRepository;
use App\Repositories\Core\CoreMetodoPagamentoRepository;
use App\Repositories\Core\CoreMovimentacaoEstoqueRepository;
use App\Repositories\Core\CorePedidoRepository;
use App\Repositories\Core\CorePerfilAcessosRepository;
use App\Repositories\Core\CorePerfilRepository;
use App\Repositories\Core\CoreProdutoRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(AcessoRepository::class, CoreAcessoRepository::class);
        $this->app->bind(ColaboradorRepository::class, CoreColaboradorRepository::class);
        $this->app->bind(PerfilRepository::class, CorePerfilRepository::class);
        $this->app->bind(PerfilAcessosRepository::class, CorePerfilAcessosRepository::class);
        $this->app->bind(MetodoPagamentoRepository::class, CoreMetodoPagamentoRepository::class);
        $this->app->bind(ProdutoRepository::class, CoreProdutoRepository::class);
        $this->app->bind(EstoqueRepository::class, CoreEstoqueRepository::class);
        $this->app->bind(ClienteRepository::class, CoreClienteRepository::class);
        $this->app->bind(PedidoRepository::class, CorePedidoRepository::class);
        $this->app->bind(FornecedorRepository::class, CoreFornecedorRepository::class);
        $this->app->bind(MovimentacaoEstoqueRepository::class, CoreMovimentacaoEstoqueRepository::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
