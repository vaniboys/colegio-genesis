<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AlunoMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!auth()->check()) {
            return redirect('/login');
        }
        
        if (auth()->user()->role !== 'aluno') {
            if (auth()->user()->role === 'admin') {
                return redirect('/admin');
            }
            if (auth()->user()->role === 'professor') {
                return redirect('/professor/dashboard');
            }
            return redirect('/login');
        }
        
        return $next($request);
    }
}