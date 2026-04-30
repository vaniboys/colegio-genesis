<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminAccessMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // ✅ Se não estiver autenticado, deixa o Filament tratar
        if (!auth()->check()) {
            return $next($request);
        }

        $user = auth()->user();
        
        // Apenas Admin pode acessar
        if ($user->role !== 'admin') {
            // Faz logout e redireciona para fora do admin
            auth()->logout();
            return redirect('/')->with('error', 'Acesso restrito a administradores.');
        }
        
        return $next($request);
    }
}