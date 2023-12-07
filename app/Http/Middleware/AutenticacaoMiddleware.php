<?php

namespace App\Http\Middleware;

use App\Models\Colaborador;
use Closure;

class AutenticacaoMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $metodo_autenticacao, $perfil, $param3, $param4)
    {
        /** @var Colaborador $colaborador */
        $colaborador = session('colaborador');

        if(isset($colaborador->email) && $colaborador->email != '') {
            return $next($request);
        } else {
            return redirect()->route('site.login', ['erro' => 2]);
        }
    }
}
