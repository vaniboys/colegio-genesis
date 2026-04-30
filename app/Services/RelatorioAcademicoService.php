<?php

namespace App\Services;

use App\Models\Aluno;
use App\Models\Nota;
use App\Models\Turma;
use App\Models\Matricula;
use Illuminate\Support\Facades\Cache;

class RelatorioAcademicoService
{
    /**
     * Obter estatísticas gerais com cache de 60 minutos
     */
    public static function getEstatisticasGerais(): array
    {
        return Cache::remember('dashboard_stats', 60, function () {
            $totalNotas = Nota::count();
            $aprovados = Nota::where('situacao', 'aprovado')->count();
            
            return [
                'total_alunos' => Aluno::count(),
                'total_turmas' => Turma::where('estado', 'ativa')->count(),
                'total_matriculas' => Matricula::where('situacao', 'ativa')->count(),
                'media_geral' => round(Nota::avg('media_trimestral') ?? 0, 1),
                'taxa_aprovacao' => $totalNotas > 0 ? round(($aprovados / $totalNotas) * 100) : 0,
                'total_aprovados' => $aprovados,
                'total_notas' => $totalNotas,
            ];
        });
    }

    /**
     * Obter boletim do aluno
     */
    public static function getBoletimAluno(int $alunoId): array
    {
        return Cache::remember("boletim_aluno_{$alunoId}", 30, function () use ($alunoId) {
            $aluno = Aluno::with(['matriculas.turma', 'matriculas.notas.disciplina'])->find($alunoId);
            
            if (!$aluno || !$aluno->matriculas->first()) {
                return [];
            }

            $matricula = $aluno->matriculas->first();
            $notas = $matricula->notas;
            
            return [
                'aluno' => $aluno,
                'turma' => $matricula->turma,
                'notas' => $notas,
                'media_geral' => round($notas->avg('media_trimestral') ?? 0, 1),
                'total_faltas' => $notas->sum('faltas'),
                'situacao' => $notas->avg('media_trimestral') >= 10 ? 'Aprovado' : 'Reprovado',
            ];
        });
    }

    /**
     * Obter relatório da turma
     */
    public static function getRelatorioTurma(int $turmaId): array
    {
        return Cache::remember("relatorio_turma_{$turmaId}", 30, function () use ($turmaId) {
            $turma = Turma::with(['alunos.notas'])->find($turmaId);
            
            if (!$turma) return [];

            $alunos = $turma->alunos;
            $notas = Nota::whereIn('aluno_id', $alunos->pluck('id'))->get();
            
            return [
                'turma' => $turma,
                'total_alunos' => $alunos->count(),
                'media_turma' => round($notas->avg('media_trimestral') ?? 0, 1),
                'melhor_nota' => round($notas->max('media_trimestral') ?? 0, 1),
                'pior_nota' => round($notas->min('media_trimestral') ?? 0, 1),
                'taxa_aprovacao' => $notas->count() > 0 
                    ? round(($notas->where('situacao', 'aprovado')->count() / $notas->count()) * 100) 
                    : 0,
            ];
        });
    }

    /**
     * Limpar cache
     */
    public static function limparCache(): void
    {
        Cache::forget('dashboard_stats');
        Cache::flush();
    }
}