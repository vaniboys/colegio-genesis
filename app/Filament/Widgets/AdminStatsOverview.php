<?php

namespace App\Filament\Widgets;

use App\Models\Aluno;
use App\Models\Professor;
use App\Models\Turma;
use App\Models\Matricula;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class AdminStatsOverview extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Alunos', Aluno::count())
                ->description('Total de alunos')
                ->icon('heroicon-o-user-group')
                ->color('primary'),

            Stat::make('Professores', Professor::count())
                ->description('Corpo docente')
                ->icon('heroicon-o-academic-cap')
                ->color('success'),

            Stat::make('Turmas', Turma::count())
                ->description('Turmas ativas')
                ->icon('heroicon-o-building-office')
                ->color('info'),

            Stat::make('Matrículas', Matricula::count())
                ->description('Inscrições totais')
                ->icon('heroicon-o-clipboard-document-check')
                ->color('warning'),
        ];
    }
}