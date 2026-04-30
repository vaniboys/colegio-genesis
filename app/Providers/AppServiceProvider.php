<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Matricula;
use App\Observers\MatriculaObserver;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Registar o Observer da Matrícula
        Matricula::observe(MatriculaObserver::class);
    }
}