<?php

namespace App\Providers\Filament;

use Filament\Panel;
use Filament\PanelProvider;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\NavigationGroup;
use Filament\Pages;
use Filament\Widgets;
use Filament\Support\Colors\Color;

use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login()
            ->profile()

            //  DESIGN
            ->brandName('Colégio Gênesis')
            ->brandLogo(asset('images/logo-admin.png'))
            ->brandLogoHeight('2.5rem')
            ->favicon(asset('images/favicon.ico'))
            ->font('Poppins')
            ->darkMode(false)

            ->colors([
                'primary' => '#1e3a8a',
                'success' => '#10b981',
                'warning' => '#f59e0b',
                'danger' => '#dc2626',
            ])

            //  MENU
            ->navigationGroups([
                // 1. Dashboard
                NavigationGroup::make()->label('Dashboard')->icon('heroicon-o-home'),
                // 2. Gestão de Alunos
                NavigationGroup::make()->label('Gestão de Alunos'),               
                // 3. Gestão de Professores
                NavigationGroup::make()->label('Gestão de Professores'),   
                // 4. Gestão de Turmas
                NavigationGroup::make()->label('Gestão de Turmas'),
                // 5. Académico
                NavigationGroup::make()->label('Gestão Académica'),
                // 6. Financeiro
                NavigationGroup::make()->label('Financeiro'),
                // 7. Comunicação
                NavigationGroup::make()->label('Comunicação'),
                // 8. Relatórios
                NavigationGroup::make()->label('Relatórios'),
                // 9. Administração
                NavigationGroup::make()->label('Gestão de utilizadores'),
            ])

            // AUTO DISCOVERY (USAR SÓ ISSO)
            ->discoverResources(
                in: app_path('Filament/Resources'),
                for: 'App\\Filament\\Resources'
            )
            ->discoverPages(
                in: app_path('Filament/Pages'),
                for: 'App\\Filament\\Pages'
            )
            ->pages([

                \App\Filament\Pages\AdminDashboard::class,
                \App\Filament\Pages\BoletinsPage::class,

            ])
            ->discoverWidgets(
                in: app_path('Filament/Widgets'),
                for: 'App\\Filament\\Widgets'
            )

            //  DASHBOARD AVANÇADO
            ->widgets([
                \Widgets\AccountWidget::class,
                \App\Filament\Widgets\BoletimStatsWidget::class,
                \App\Filament\Widgets\EstatisticasGeraisWidget::class,
            ])

            //  MIDDLEWARE
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])

            //  LOGIN
            ->authMiddleware([
                Authenticate::class,
            ])

            //  PROTEÇÃO ADMIN
            ->bootUsing(function () {
                if (!auth()->check()) {
                    return;
                }

                if (!auth()->user()->hasRole('admin')) {
                    abort(403);
                }
            });
    }
}