<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ProfessorMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!auth()->check()) {
            return redirect('/login');
        }
        
        if (auth()->user()->role !== 'professor') {
            // Redirecionar para área correta
            if (auth()->user()->role === 'admin') {
                return redirect('/admin');
            }
            if (auth()->user()->role === 'aluno') {
                return redirect('/aluno/dashboard');
            }
            return redirect('/login');
        }
        
        return $next($request);
    }
}