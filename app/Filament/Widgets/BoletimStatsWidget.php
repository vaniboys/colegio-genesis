<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;

class BoletimStatsWidget extends Widget
{
    protected int|string|array $columnSpan = 'full';
    protected string $view = 'filament.widgets.boletim-stats';

    public function getAlunos()
    {
        return \App\Models\Aluno::with('turmas')
            ->where('situacao', 'activo')
            ->limit(50)
            ->get()
            ->map(function ($aluno) {
                $turma = $aluno->turmas->first();
                return [
                    'id' => $aluno->id,
                    'processo' => $aluno->processo,
                    'nome' => $aluno->nome_completo,
                    'turma' => $turma ? $turma->nome : 'N/A',
                    'label' => "{$aluno->processo} - {$aluno->nome_completo}" . 
                              ($turma ? " ({$turma->nome})" : ''),
                ];
            });
    }

    public function getTurmas()
    {
        return \App\Models\Turma::where('estado', 'ativa')
            ->limit(50)
            ->get()
            ->map(function ($turma) {
                return [
                    'id' => $turma->id,
                    'nome' => $turma->nome,
                    'turno' => $turma->turno,
                    'alunos' => $turma->alunos()->count(),
                    'vagas' => $turma->capacidade_maxima - $turma->vagas_ocupadas,
                ];
            });
    }
}