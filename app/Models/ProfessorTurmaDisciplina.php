<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProfessorTurmaDisciplina extends Model
{
    protected $table = 'professor_turma_disciplina';

    protected $fillable = [
        'professor_id',
        'turma_id',
        'disciplina_id',
        'ano_lectivo_id',
        'carga_horaria',
        'ativo',
    ];

    protected $casts = [
        'ativo' => 'boolean',
    ];

    public function professor()
    {
        return $this->belongsTo(Professor::class);
    }

    public function turma()
    {
        return $this->belongsTo(Turma::class);
    }

    public function disciplina()
    {
        return $this->belongsTo(Disciplina::class);
    }

    public function anoLectivo()
    {
        return $this->belongsTo(AnoLectivo::class);
    }

    public function scopeAtivo($query)
    {
        return $query->where('ativo', true);
    }
}