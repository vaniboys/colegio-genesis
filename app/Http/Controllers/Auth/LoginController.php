<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email|max:255',
            'password' => 'required|min:6|max:50',
        ]);

        $key = 'login.' . $request->ip();

        // 🔒 Proteção contra brute force
        if (RateLimiter::tooManyAttempts($key, 5)) {
            $seconds = RateLimiter::availableIn($key);

            return back()->withErrors([
                'email' => 'Muitas tentativas. Tente novamente em ' . ceil($seconds / 60) . ' minutos.',
            ]);
        }

        // 🔐 Tentativa de login
        if (Auth::attempt($request->only('email', 'password'), $request->remember)) {

            $user = Auth::user();

            // ❌ BLOQUEAR ADMIN E SECRETARIA NO LOGIN WEB
            if ($user->hasRole(['admin', 'secretaria'])) {
                Auth::logout();

                RateLimiter::hit($key, 300);

                return back()->withErrors([
                    'email' => 'Área exclusiva do painel administrativo. Use /admin/login',
                ]);
            }

            // ✅ SUCESSO
            RateLimiter::clear($key);
            $request->session()->regenerate();

            // 🔁 Redirecionamento inteligente
            if ($user->hasRole('professor')) {
                return redirect()->intended('/professor/dashboard');
            }

            if ($user->hasRole('aluno')) {
                return redirect()->intended('/aluno/dashboard');
            }

            // fallback
            return redirect('/');
        }

        // ❌ Falha login
        RateLimiter::hit($key, 300);

        $userExists = \App\Models\User::where('email', $request->email)->exists();

        if (!$userExists) {
            return back()->withErrors([
                'email' => 'Email não registado.',
            ])->withInput($request->only('email'));
        }

        return back()->withErrors([
            'password' => 'Senha incorreta.',
        ])->withInput($request->only('email'));
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')->with('success', 'Saiu com sucesso.');
    }
}