<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

class Matricula extends Model implements Auditable
{
    use AuditableTrait;

    protected $table = 'matriculas';
    
    protected $fillable = [
        'numero_matricula', 'aluno_id', 'turma_id', 'ano_lectivo_id',
        'data_matricula', 'tipo', 'situacao', 'escola_origem',
        'ano_lectivo_origem', 'observacoes',
    ];

    protected $casts = [
        'data_matricula' => 'date',
    ];

    // ==================== CONSTANTES ====================
    const SITUACAO_ATIVA = 'ativa';
    const SITUACAO_PENDENTE = 'pendente';
    const SITUACAO_CANCELADA = 'cancelada';
    const SITUACAO_CONCLUIDA = 'concluida';

    // ==================== RELACIONAMENTOS ====================
    public function aluno() { return $this->belongsTo(Aluno::class, 'aluno_id'); }
    public function turma() { return $this->belongsTo(Turma::class); }
    public function anoLectivo() { return $this->belongsTo(AnoLectivo::class, 'ano_lectivo_id'); }
    public function notas() { return $this->hasMany(Nota::class); }
    public function propinas() { return $this->hasMany(Propina::class); }

    // ==================== MÉTODOS ====================
    
    public static function alunoJaMatriculado($alunoId): bool
    {
        return self::where('aluno_id', $alunoId)
            ->where('situacao', self::SITUACAO_ATIVA)
            ->exists();
    }

    public function atualizarSituacao(): void
    {
        if (!$this->exists) return;
        if (in_array($this->situacao, [self::SITUACAO_CONCLUIDA, self::SITUACAO_CANCELADA])) return;

        $atraso = Propina::query()
            ->select('id')
            ->where('matricula_id', $this->id)
            ->where('status', 'pendente')
            ->where('data_vencimento', '<', now()->subDays(30))
            ->limit(1)
            ->exists();

        $this->update(['situacao' => $atraso ? self::SITUACAO_PENDENTE : self::SITUACAO_ATIVA]);
    }

    public function cancelar(): void
    {
        $this->update(['situacao' => self::SITUACAO_CANCELADA]);
        Propina::where('matricula_id', $this->id)
            ->where('status', 'pendente')
            ->where('data_vencimento', '>', now())
            ->update(['status' => self::SITUACAO_CANCELADA]);
    }

    public function concluir(): void { $this->update(['situacao' => self::SITUACAO_CONCLUIDA]); }
    public function reabrir(): void { $this->update(['situacao' => self::SITUACAO_ATIVA]); }
    public function isAtiva(): bool { return $this->situacao === self::SITUACAO_ATIVA; }
    public function isPendente(): bool { return $this->situacao === self::SITUACAO_PENDENTE; }

    // ==================== SCOPES ====================
    public function scopeAtiva($query) { return $query->where('situacao', self::SITUACAO_ATIVA); }
    public function scopePendente($query) { return $query->where('situacao', self::SITUACAO_PENDENTE); }
    public function scopeCancelada($query) { return $query->where('situacao', self::SITUACAO_CANCELADA); }
    public function scopeConcluida($query) { return $query->where('situacao', self::SITUACAO_CONCLUIDA); }
}