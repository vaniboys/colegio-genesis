<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Console\Scheduling\Schedule;  // ✅ Adiciona este import

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'role' => \App\Http\Middleware\CheckUserRole::class,
            'aluno' => \App\Http\Middleware\AlunoMiddleware::class,
            'admin.access' => \App\Http\Middleware\AdminAccessMiddleware::class,
        ]);
    })
    ->withSchedule(function (Schedule $schedule) {  // ✅ Adiciona esta seção
        // Verificar situação das matrículas diariamente
        $schedule->command('matriculas:verificar-situacao')->daily();
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();