<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

class Disciplina extends Model implements Auditable
{
    use AuditableTrait;
    
    protected $table = 'disciplinas';
    
    protected $fillable = [
        'nome',
        'codigo',
        'carga_horaria',
    ];

    // ==================== RELACIONAMENTOS EXISTENTES ====================
    
    public function classes()
    {
        return $this->belongsToMany(Classe::class, 'classe_disciplina')
                    ->withPivot(['carga_horaria_semanal', 'obrigatoria'])
                    ->withTimestamps();
    }

    public function professores()
    {
        return $this->belongsToMany(Professor::class, 'professor_disciplinas')
                    ->withPivot(['prioridade', 'ativo'])
                    ->withTimestamps();
    }

    public function professoresAtribuidos()
    {
        return $this->belongsToMany(Professor::class, 'professor_turma_disciplina')
                    ->withPivot(['turma_id', 'ano_lectivo_id', 'carga_horaria', 'ativo'])
                    ->withTimestamps();
    }

    // ==================== NOVOS RELACIONAMENTOS ====================
    
    /**
     * Turmas que têm esta disciplina (via tabela disciplina_turma)
     */
    public function turmas()
    {
        return $this->belongsToMany(Turma::class, 'disciplina_turma')
                    ->withPivot('professor_id', 'carga_horaria_semanal', 'obrigatoria')
                    ->withTimestamps();
    }
}