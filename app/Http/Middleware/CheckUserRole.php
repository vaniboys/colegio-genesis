<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckUserRole
{
    public function handle(Request $request, Closure $next, $role)
    {
        // Se não estiver logado, redireciona para login
        if (!auth()->check()) {
            return redirect('/login');
        }

        $user = auth()->user();
        
        // Verificar se o usuário tem a role permitida
        if ($user->role !== $role) {
            // Redirecionar para a área correta baseada na role
            if ($user->role === 'admin') {
                return redirect('/admin');
            } elseif ($user->role === 'secretaria') {
                return redirect('/admin');
            } elseif ($user->role === 'professor') {
                return redirect('/professor/dashboard');
            } elseif ($user->role === 'aluno') {
                return redirect('/aluno/dashboard');
            }
            
            return redirect('/login')->withErrors(['email' => 'Acesso não autorizado.']);
        }

        return $next($request);
    }
}