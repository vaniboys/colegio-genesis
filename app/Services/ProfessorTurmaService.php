<?php

namespace App\Services;

use App\Models\ProfessorTurmaDisciplina;
use App\Models\Turma;
use Illuminate\Support\Facades\DB;

class ProfessorTurmaService
{
    public function atribuir(array $data): ProfessorTurmaDisciplina
    {
        return ProfessorTurmaDisciplina::create($data);
    }

    public function remover(int $id): void
    {
        ProfessorTurmaDisciplina::findOrFail($id)->delete();
    }

    public function listarPorTurma(int $turmaId): array
    {
        return ProfessorTurmaDisciplina::with(['professor', 'disciplina'])
            ->where('turma_id', $turmaId)
            ->where('ativo', true)
            ->get()
            ->toArray();
    }

    public function definirProfessorPrincipal(int $turmaId, int $professorId): void
    {
        Turma::where('id', $turmaId)->update(['professor_principal_id' => $professorId]);
    }
}