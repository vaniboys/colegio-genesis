<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

class Turma extends Model implements Auditable
{
    use AuditableTrait;
    protected $table = 'turmas';
    
    protected $fillable = [
        'nome', 'classe_id', 'nivel_ensino_id', 'turno',
        'capacidade_maxima', 'vagas_ocupadas', 'monodocencia',
        'professor_principal_id', 'ano_lectivo_id', 'curso_id', 'sala_id', 'estado'
    ];

    // ==================== RELACIONAMENTOS EXISTENTES ====================
    public function classe()
    {
        return $this->belongsTo(Classe::class);
    }

    public function curso()
    {
        return $this->belongsTo(Curso::class);
    }

    public function professorPrincipal()
    {
        return $this->belongsTo(Professor::class, 'professor_principal_id');
    }

    public function professor()
    {
        return $this->belongsTo(Professor::class, 'professor_principal_id');
    }

    public function alunos()
    {
        return $this->belongsToMany(Aluno::class, 'matriculas', 'turma_id', 'aluno_id');
    }

    public function matriculas()
    {
        return $this->hasMany(Matricula::class);
    }

    public function nivelEnsino()
    {
        return $this->belongsTo(NivelEnsino::class);
    }

    public function anoLectivo()
    {
        return $this->belongsTo(AnoLectivo::class);
    }

    // ==================== NOVOS RELACIONAMENTOS ====================
    
    /**
     * Disciplinas associadas a esta turma (via tabela disciplina_turma)
     */
    public function disciplinas()
    {
        return $this->belongsToMany(Disciplina::class, 'disciplina_turma')
                    ->withPivot('professor_id', 'carga_horaria_semanal', 'obrigatoria')
                    ->withTimestamps();
    }

    /**
     * Sincronizar disciplinas da classe para a turma
     */
    public static function syncDisciplinasFromClasse($turmaId)
    {
        $turma = self::with('classe.disciplinas')->find($turmaId);
        
        if ($turma && $turma->classe && $turma->classe->disciplinas->count() > 0) {
            $disciplinasData = [];
            foreach ($turma->classe->disciplinas as $disciplina) {
                $disciplinasData[$disciplina->id] = [
                    'carga_horaria_semanal' => $disciplina->pivot->carga_horaria_semanal ?? 4,
                    'obrigatoria' => $disciplina->pivot->obrigatoria ?? true,
                    'professor_id' => null,
                ];
            }
            $turma->disciplinas()->sync($disciplinasData);
            return true;
        }
        return false;
    }

    /**
     * Boot do modelo
     */
    protected static function booted()
    {
        static::created(function ($turma) {
            if ($turma->classe_id) {
                self::syncDisciplinasFromClasse($turma->id);
            }
        });
        
        static::updated(function ($turma) {
            if ($turma->wasChanged('classe_id') && $turma->classe_id) {
                $turma->disciplinas()->detach();
                self::syncDisciplinasFromClasse($turma->id);
            }
        });
    }
}