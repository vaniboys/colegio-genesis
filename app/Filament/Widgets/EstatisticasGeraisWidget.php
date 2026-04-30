<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Services\RelatorioAcademicoService;

class EstatisticasGeraisWidget extends BaseWidget
{
    protected function getStats(): array
    {
        $stats = RelatorioAcademicoService::getEstatisticasGerais();

        return [
            Stat::make('Total Alunos', $stats['total_alunos'])
                ->description('Alunos registados')
                ->icon('heroicon-o-user-group')
                ->color('primary'),

            Stat::make('Turmas Ativas', $stats['total_turmas'])
                ->description('Em funcionamento')
                ->icon('heroicon-o-building-library')
                ->color('success'),

            Stat::make('Média Geral', $stats['media_geral'])
                ->description('Todas as disciplinas')
                ->icon('heroicon-o-chart-bar')
                ->color('warning'),

            Stat::make('Taxa de Aprovação', $stats['taxa_aprovacao'] . '%')
                ->description($stats['total_aprovados'] . ' de ' . $stats['total_notas'])
                ->icon('heroicon-o-academic-cap')
                ->color($stats['taxa_aprovacao'] >= 50 ? 'success' : 'danger'),
        ];
    }
}