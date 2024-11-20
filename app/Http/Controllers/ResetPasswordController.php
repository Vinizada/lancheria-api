<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\View\View;

class ResetPasswordController extends Controller
{
    /**
     * Exibe o formulário para redefinir a senha.
     *
     * @param  string  $token
     * @return View
     */
    public function showResetForm($token)
    {
        return view('reset', ['token' => $token]);
    }

    /**
     * Processa a redefinição de senha.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function reset(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|confirmed|min:6',
            'token' => 'required'
        ]);

        $status = Password::broker('colaboradores')->reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($colaborador, $password) {
                $colaborador->forceFill([
                    'senha  a' => Hash::make($password),
                ])->save();
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            return redirect()->route('site.login')->with('status', 'Senha redefinida com sucesso! Faça login com sua nova senha.');
        }

        return back()->withErrors(['email' => __($status)]);
    }
}
