<?php

namespace App\Services;

use App\Models\Matricula;
use App\Models\Aluno;
use Illuminate\Support\Facades\DB;

class MatriculaService
{
    public static function matricular(array $data): Matricula
    {
        return DB::transaction(function () use ($data) {
            
            $aluno = Aluno::find($data['aluno_id']);
            
            $matricula = Matricula::create([
                'aluno_id'       => $data['aluno_id'],
                'turma_id'       => $data['turma_id'],
                'ano_lectivo_id' => $data['ano_lectivo_id'],
                'data_matricula' => $data['data_matricula'] ?? now(),
                'situacao'       => $data['situacao'] ?? 'ativa',
            ]);

            if ($aluno && $aluno->situacao === 'inactivo') {
                $aluno->update(['situacao' => 'activo']);
            }

            if ($matricula->turma) {
                $matricula->turma->increment('vagas_ocupadas');
            }

            return $matricula;
        });
    }
}