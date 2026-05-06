<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Support\Facades\DB;
use OwenIt\Auditing\Auditable as AuditableTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Aluno extends Model implements Auditable
{
    use AuditableTrait, SoftDeletes, HasFactory;

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
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    protected $attributes = [
        'situacao' => 'inactivo',
    ];

    // ==================== BOOT - GERAÇÃO AUTOMÁTICA DO PROCESSO ====================
    
    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($aluno) {
            if (empty($aluno->processo)) {
                $ano = now()->format('y');
                // Melhorado para evitar conflitos em alta concorrência
                $maxProcesso = static::where('processo', 'like', $ano . '%')
                    ->max('processo');
                
                if ($maxProcesso) {
                    $numero = (int) substr($maxProcesso, 2) + 1;
                } else {
                    $numero = 1;
                }
                
                $aluno->processo = $ano . str_pad($numero, 5, '0', STR_PAD_LEFT);
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
        return $this->hasMany(Matricula::class)->orderBy('created_at', 'desc');
    }
    
    public function turmas()
    {
        return $this->belongsToMany(Turma::class, 'matriculas', 'aluno_id', 'turma_id')
            ->withTimestamps()
            ->withPivot('ano_lectivo', 'situacao');
    }

    public function matriculaAtiva()
    {
        return $this->hasOne(Matricula::class)->where('situacao', 'activa')->latest();
    }

    public function turmaAtual()
    {
        return $this->matriculaAtiva()->with('turma');
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

    public function scopeTransferido($query)
    {
        return $query->where('situacao', 'transferido');
    }

    public function scopePorProcesso($query, $processo)
    {
        return $query->where('processo', 'LIKE', "%{$processo}%");
    }

    public function scopePorNome($query, $nome)
    {
        return $query->where('nome_completo', 'LIKE', "%{$nome}%");
    }

    // ==================== ACCESSORS & MUTATORS ====================
    
    public function getSituacaoFormatadaAttribute(): string
    {
        return match($this->situacao) {
            'activo' => '✅ Activo',
            'inactivo' => '❌ Inactivo',
            'transferido' => '🔄 Transferido',
            default => $this->situacao,
        };
    }

    public function getSexoFormatadoAttribute(): string
    {
        return $this->sexo === 'M' ? 'Masculino' : 'Feminino';
    }

    public function getIdadeAttribute(): ?int
    {
        return $this->data_nascimento?->age;
    }

    public function getNomeCompletoUpperAttribute(): string
    {
        return mb_strtoupper($this->nome_completo);
    }

    // ==================== VALIDAÇÕES ====================
    
    public function ativar()
    {
        $this->update(['situacao' => 'activo']);
    }

    public function inativar()
    {
        $this->update(['situacao' => 'inactivo']);
    }

    public function transferir()
    {
        $this->update(['situacao' => 'transferido']);
    }

    public function podeMatricular(): bool
    {
        return $this->situacao === 'activo' || $this->situacao === 'inactivo';
    }
}