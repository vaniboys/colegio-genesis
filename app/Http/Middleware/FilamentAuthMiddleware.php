<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class FilamentAuthMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!auth()->check()) {
            return redirect('/admin/login');
        }

        $user = auth()->user();
        
        // Apenas Admin e Secretaria podem acessar o admin
        if ($user->role !== 'admin' && $user->role !== 'secretaria') {
            auth()->logout();
            return redirect('/admin/login')->withErrors([
                'email' => 'Acesso restrito. Apenas Administradores e Secretaria podem acessar esta área.'
            ]);
        }
        
        return $next($request);
    }
}