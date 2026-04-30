<?php

namespace App\Filament\Widgets;

use App\Models\Aluno;
use App\Models\Professor;
use App\Models\Turma;
use App\Models\Matricula;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Alunos', Aluno::count())
                ->description('Total registados no sistema')
                ->color('primary')
                ->icon('heroicon-o-user-group'),

            Stat::make('Professores', Professor::count())
                ->description('Corpo docente ativo')
                ->color('success')
                ->icon('heroicon-o-academic-cap'),

            Stat::make('Turmas', Turma::count())
                ->description('Turmas criadas')
                ->color('info')
                ->icon('heroicon-o-building-office'),

            Stat::make('Matrículas', Matricula::count())
                ->description('Total de inscrições')
                ->color('warning')
                ->icon('heroicon-o-clipboard-document-check'),
        ];
    }
}