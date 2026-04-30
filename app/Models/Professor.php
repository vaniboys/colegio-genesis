<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

class Professor extends Model implements Auditable
{
    use AuditableTrait;
    
    protected $table = 'professores';
    
    protected $fillable = [
        'nome_completo',
        'email',
        'bi',
        'nuit',
        'telefone',
        'categoria',
        'especialidade',
        'habilitacoes',
        'data_contratacao',
        'regime',
        'situacao',
        'observacoes',
        // ✅ NOVOS CAMPOS
        'carga_horaria_max',
        'carga_atual',
    ];

    protected $casts = [
        'data_contratacao' => 'date',
        'carga_horaria_max' => 'integer',
        'carga_atual' => 'integer',
    ];

    // ==================== RELACIONAMENTOS ====================

    // Turmas onde é professor principal
    public function turmasPrincipais()
    {
        return $this->hasMany(Turma::class, 'professor_principal_id');
    }

    // Todas as turmas que leciona (via pivot)
    public function turmas()
    {
        return $this->belongsToMany(Turma::class, 'professor_turma_disciplina')
            ->withPivot(['disciplina_id', 'ano_lectivo_id', 'carga_horaria', 'ativo'])
            ->withTimestamps();
    }

    // Disciplinas que o professor PODE ensinar
    public function disciplinas()
    {
        return $this->belongsToMany(Disciplina::class, 'professor_disciplinas')
            ->withPivot(['prioridade', 'ativo'])
            ->withTimestamps();
    }

    // Disciplinas que está a lecionar (via pivot turma)
    public function disciplinasEmCurso()
    {
        return $this->belongsToMany(Disciplina::class, 'professor_turma_disciplina')
            ->withPivot(['turma_id', 'ano_lectivo_id', 'carga_horaria', 'ativo'])
            ->withTimestamps();
    }

    // ==================== SCOPES ====================
    
    public function scopeAtivo($query)
    {
        return $query->where('situacao', 'activo');
    }

    public function scopeComDisponibilidade($query)
    {
        return $query->whereColumn('carga_atual', '<', 'carga_horaria_max');
    }

    // ==================== MÉTODOS AUXILIARES ====================

    public function getCargaRestanteAttribute(): int
    {
        return max(0, $this->carga_horaria_max - $this->carga_atual);
    }

    public function getEstaSobrecarregadoAttribute(): bool
    {
        return $this->carga_atual >= $this->carga_horaria_max;
    }

    public function getPercentualCargaAttribute(): float
    {
        if ($this->carga_horaria_max == 0) return 0;
        return round(($this->carga_atual / $this->carga_horaria_max) * 100, 1);
    }
}