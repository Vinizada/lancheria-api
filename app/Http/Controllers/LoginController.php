<?php

namespace App\Http\Controllers;

use App\Models\Colaborador;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function index(Request $request)
    {
        $erro = '';

        if($request->get('erro') == 1) {
            $erro = 'Usuário e ou senha não existe';
        }

        if($request->get('erro') == 2) {
            $erro = 'Necessário realizar login para ter acesso a página';
        }

        return view('site.login', ['titulo' => 'Login', 'erro' => $erro]);
    }

    public function autenticar(Request $request)
    {
        $regras = [
            'usuario' => 'email',
            'senha' => 'required'
        ];

        $feedback = [
            'usuario.email' => 'O campo usuário (e-mail) é obrigatório',
            'senha.required' => 'O campo senha é obrigatório'
        ];

        $request->validate($regras, $feedback);

        $email = $request->get('usuario');
        $password = $request->get('senha');

        /** @var Colaborador $colaborador */
        $colaborador = Colaborador::query()
            ->where('email', $email)
            ->where('senha', $password)
            ->first();

        if(isset($colaborador->nome)) {

            session_start();
            $_SESSION['nome'] = $colaborador->nome;
            $_SESSION['email'] = $colaborador->email;

            return redirect()->route('app.home');
        } else {
            return redirect()->route('site.login', ['erro' => 1]);
        }
    }

    public function sair()
    {
        session_destroy();
        return redirect()->route('site.index');
    }
}
