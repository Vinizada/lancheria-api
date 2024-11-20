<?php

namespace App\Http\Controllers;

use App\Models\Colaborador;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class ForgotPasswordController extends Controller
{
    /**
     * Exibe o formulário para solicitar o link de redefinição de senha.
     *passwords.email
     * @return \Illuminate\View\View
     */
    public function showLinkRequestForm()
    {
        return view('email');
    }

    /**
     * Processa a solicitação de redefinição de senha.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $colaborador = Colaborador::where('email', $request->email)->first();

        if (!$colaborador) {
            return back()->withErrors(['email' => 'Esse e-mail não está cadastrado em nosso sistema, tente novamente.']);
        }

        $status = Password::broker('colaboradores')->sendResetLink($request->only('email'));

        return $status === Password::RESET_LINK_SENT
            ? back()->with('status', 'E-mail com o link para recuperação enviado com sucesso!')
            : back()->withErrors(['email' => 'Ocorreu um problema ao enviar o e-mail. Tente novamente mais tarde.']);
    }
}
