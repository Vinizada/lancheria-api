<?php

namespace App\Http\Controllers;

use App\Models\Colaborador;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    /**
     * Exibe a tela de login.
     *
     * @param Request $request
     * @return Application|Factory|View
     */
    public function index(Request $request)
    {
        $erro = '';

        if ($request->get('erro') == 1) {
            $erro = 'Usuário e/ou senha não existem.';
        }

        if ($request->get('erro') == 2) {
            $erro = 'É necessário realizar login para acessar a página.';
        }

        return view('login', ['titulo' => 'Login', 'erro' => $erro]);
    }

    /**
     * Realiza a autenticação do colaborador.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function autenticar(Request $request)
    {
        $regras = [
            'usuario' => 'required|email',
            'senha' => 'required',
        ];

        $feedback = [
            'usuario.required' => 'O campo usuário (e-mail) é obrigatório.',
            'usuario.email' => 'O campo usuário deve ser um e-mail válido.',
            'senha.required' => 'O campo senha é obrigatório.',
        ];

        $request->validate($regras, $feedback);

        /** @var Colaborador $colaborador */
        $colaborador = Colaborador::query()
            ->where('email', $request->get('usuario'))
            ->first();

        if ($colaborador && Hash::check($request->get('senha'), $colaborador->getAuthPassword())) {
            Auth::guard('colaborador')->login($colaborador);
            return redirect()->route('app.home');
        } else {
            return redirect()->route('site.login', ['erro' => 1]);
        }
    }

    /**
     * Realiza o logout do colaborador autenticado.
     *
     * @return RedirectResponse
     */
    public function sair()
    {
        Auth::logout();
        return redirect()->route('site.login');
    }
}
