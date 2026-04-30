<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Classe extends Model
{
    protected $table = 'classes';
    
    protected $fillable = [
        'nome',
        'nivel_ensino_id',
        'tem_curso',
    ];

    protected $casts = [
        'tem_curso' => 'boolean',
    ];

    // Disciplinas desta classe
    public function disciplinas()
    {
        return $this->belongsToMany(Disciplina::class, 'classe_disciplina')
            ->withPivot(['carga_horaria_semanal', 'obrigatoria'])
            ->withTimestamps();
    }

    public function nivelEnsino()
    {
        return $this->belongsTo(NivelEnsino::class);
    }

    public function turmas()
    {
        return $this->hasMany(Turma::class, 'classe_id');
    }

    // ✅ Scope para classes com curso
    public function scopeComCurso($query)
    {
        return $query->where('tem_curso', true);
    }

    // ✅ Scope para classes sem curso
    public function scopeSemCurso($query)
    {
        return $query->where('tem_curso', false);
    }
}