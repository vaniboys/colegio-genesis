<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Support\Facades\DB; 
use OwenIt\Auditing\Auditable as AuditableTrait;

class Aluno extends Model implements Auditable
{
    use AuditableTrait, SoftDeletes;

    protected $table = 'alunos';
    
    protected $fillable = [
        'processo',
        'nome_completo',
        'sexo',
        'data_nascimento',
        'bi',
        'telefone',
        'email',
        'endereco',
        'municipio',
        'provincia_id',
        'encarregado_id',
        'foto',
        'situacao',
        'observacoes',
    ];

    protected $casts = [
        'data_nascimento' => 'date',
    ];

    // ==================== BOOT - GERAÇÃO AUTOMÁTICA DO PROCESSO ====================
    
 // ← Adiciona no topo

protected static function boot()
{
    parent::boot();
    
    static::creating(function ($aluno) {
        if (empty($aluno->processo)) {
            $ano = date('y');
            $count = DB::table('alunos')->count() + 1;  // ✅ Usa DB direto
            $aluno->processo = $ano . str_pad($count, 5, '0', STR_PAD_LEFT);
        }
    });
}
    // ==================== RELACIONAMENTOS ====================
    public function provincia()
    {
        return $this->belongsTo(Provincia::class);
    }

    public function matriculas()
    {
        return $this->hasMany(Matricula::class);
    }
    
    public function turmas()
    {
        return $this->belongsToMany(Turma::class, 'matriculas', 'aluno_id', 'turma_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function encarregado()
    {
        return $this->belongsTo(Encarregado::class);
    }

    // ==================== SCOPES ====================
    public function scopeAtivo($query)
    {
        return $query->where('situacao', 'activo');
    }

    public function scopeInactivo($query)
    {
        return $query->where('situacao', 'inactivo');
    }

    // ==================== ACCESSORS ====================
    public function getSituacaoFormatadaAttribute(): string
    {
        return match($this->situacao) {
            'activo' => ' Activo',
            'inactivo' => ' Inactivo',
            'transferido' => ' Transferido',
            default => $this->situacao,
        };
    }
}