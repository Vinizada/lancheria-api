<?php

namespace App\Providers;

use App\Repositories\Contracts\AcessoRepository;
use App\Repositories\Contracts\ColaboradorRepository;
use App\Repositories\Contracts\MetodoPagamentoRepository;
use App\Repositories\Contracts\PerfilAcessosRepository;
use App\Repositories\Contracts\PerfilRepository;
use App\Repositories\Core\CoreAcessoRepository;
use App\Repositories\Core\CoreColaboradorRepository;
use App\Repositories\Core\CoreMetodoPagamentoRepository;
use App\Repositories\Core\CorePerfilAcessosRepository;
use App\Repositories\Core\CorePerfilRepository;
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
