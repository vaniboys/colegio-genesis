<?php

namespace App\Services;

use App\Models\Turma;
use App\Models\Professor;
use App\Models\Disciplina;
use App\Models\ProfessorTurmaDisciplina;
use Illuminate\Support\Facades\DB;

class DistribuicaoProfessorService
{
    /**
     * Distribuir professores automaticamente para um ano lectivo
     */
    public function distribuir(int $anoLectivoId): array
    {
        $resultado = [
            'atribuicoes' => 0,
            'falhas' => 0,
            'mensagens' => [],
        ];

        DB::transaction(function () use ($anoLectivoId, &$resultado) {
            
            // Buscar turmas ativas do ano
            $turmas = Turma::where('ano_lectivo_id', $anoLectivoId)
                ->where('estado', 'ativa')
                ->get();

            foreach ($turmas as $turma) {
                
                // Buscar disciplinas do nível de ensino da turma
                $disciplinas = Disciplina::whereHas('classes', function ($q) use ($turma) {
                    $q->where('classes.id', $turma->classe_id);
                })->get();

                // Se não houver disciplinas vinculadas, pega todas
                if ($disciplinas->isEmpty()) {
                    $disciplinas = Disciplina::all();
                }

                foreach ($disciplinas as $disciplina) {
                    
                    // Já existe professor para esta turma/disciplina?
                    $existe = ProfessorTurmaDisciplina::where('turma_id', $turma->id)
                        ->where('disciplina_id', $disciplina->id)
                        ->where('ano_lectivo_id', $anoLectivoId)
                        ->exists();

                    if ($existe) continue;

                    // Encontrar melhor professor
                    $professor = $this->melhorProfessor($disciplina->id);

                    if (!$professor) {
                        $resultado['falhas']++;
                        $resultado['mensagens'][] = "Sem professor para {$disciplina->nome} na turma {$turma->nome}";
                        continue;
                    }

                    // Atribuir professor
                    ProfessorTurmaDisciplina::create([
                        'professor_id' => $professor->id,
                        'turma_id' => $turma->id,
                        'disciplina_id' => $disciplina->id,
                        'ano_lectivo_id' => $anoLectivoId,
                        'carga_horaria' => 2,
                        'ativo' => true,
                    ]);

                    // Incrementar carga atual
                    $professor->increment('carga_atual');

                    $resultado['atribuicoes']++;
                    $resultado['mensagens'][] = "{$professor->nome_completo} → {$disciplina->nome} ({$turma->nome})";
                }
            }
        });

        return $resultado;
    }

    /**
     * Escolher o melhor professor para uma disciplina
     */
    private function melhorProfessor(int $disciplinaId): ?Professor
    {
        return Professor::whereHas('disciplinas', function ($q) use ($disciplinaId) {
                $q->where('disciplina_id', $disciplinaId)->where('professor_disciplinas.ativo', true);
            })
            ->where('situacao', 'activo')
            ->whereColumn('carga_atual', '<', 'carga_horaria_max')
            ->orderBy('carga_atual') // Menos ocupado primeiro
            ->first();
    }

    /**
     * Resetar carga de todos os professores
     */
    public function resetarCarga(): void
    {
        Professor::query()->update(['carga_atual' => 0]);
    }

    /**
     * Obter resumo da distribuição
     */
    public function resumo(int $anoLectivoId): array
    {
        return [
            'total_turmas' => Turma::where('ano_lectivo_id', $anoLectivoId)->where('estado', 'ativa')->count(),
            'total_professores' => Professor::where('situacao', 'activo')->count(),
            'total_atribuicoes' => ProfessorTurmaDisciplina::where('ano_lectivo_id', $anoLectivoId)->count(),
            'professores_sem_carga' => Professor::where('carga_atual', 0)->count(),
            'professores_sobrecarregados' => Professor::whereColumn('carga_atual', '>=', 'carga_horaria_max')->count(),
        ];
    }
}