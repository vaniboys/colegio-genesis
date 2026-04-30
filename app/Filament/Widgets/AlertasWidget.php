<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;
use App\Models\Turma;
use App\Models\Matricula;

class AlertasWidget extends Widget
{
    protected string $view = 'filament.widgets.alertas-widget';
    protected int|string|array $columnSpan = 'full';

    protected function getViewData(): array
    {
        $turmasSemProfessor = Turma::whereDoesntHave('professor')->count();
        $alunosInadimplentes = 0; // Ajustar conforme tua lógica
        
        return [
            'turmasSemProfessor' => $turmasSemProfessor,
            'alunosInadimplentes' => $alunosInadimplentes,
        ];
    }
}