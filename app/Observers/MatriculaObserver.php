<?php

namespace App\Observers;

use App\Models\Matricula;

class MatriculaObserver
{
    public function creating(Matricula $matricula): void
    {
        $matricula->data_matricula ??= now();
        $matricula->situacao ??= Matricula::SITUACAO_ATIVA;
        
        // ✅ Só gera nº matrícula se não existir
        if ($matricula->aluno_id && !$matricula->numero_matricula) {
            // Verifica se o aluno já tem uma matrícula com este processo
            $processo = \App\Models\Aluno::whereKey($matricula->aluno_id)->value('processo');
            
            $existe = Matricula::where('numero_matricula', $processo)->exists();
            
            if ($existe) {
                // Gera um novo número sequencial
                $ano = date('y');
                $ultima = Matricula::where('numero_matricula', 'like', "{$ano}%")
                    ->orderBy('numero_matricula', 'desc')
                    ->first();
                $seq = $ultima ? (int) substr($ultima->numero_matricula, 2) + 1 : 1;
                $matricula->numero_matricula = $ano . str_pad($seq, 5, '0', STR_PAD_LEFT);
            } else {
                $matricula->numero_matricula = $processo;
            }
        }
    }

    public function created(Matricula $matricula): void
    {
        $aluno = $matricula->aluno;
        if ($aluno && $aluno->situacao === 'inactivo') {
            $aluno->update(['situacao' => 'activo']);
        }
        
        $turma = $matricula->turma;
        if ($turma) {
            $turma->increment('vagas_ocupadas');
        }
    }
}