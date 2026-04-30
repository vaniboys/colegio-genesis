<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

class Nota extends Model implements Auditable
{
    use AuditableTrait;

    protected $table = 'notas';
    
    protected $fillable = [
        'matricula_id', 'disciplina_id', 'trimestre',
        'avaliacao_continua', 'prova_trimestral', 'media_trimestral',
        'exame_final', 'media_final', 'faltas', 'situacao', 'observacoes',
    ];

    protected $casts = [
        'avaliacao_continua' => 'decimal:2',
        'prova_trimestral' => 'decimal:2',
        'media_trimestral' => 'decimal:2',
        'exame_final' => 'decimal:2',
        'media_final' => 'decimal:2',
    ];

    // ==================== BOOT - CÁLCULO AUTOMÁTICO ====================
protected static function boot()
{
    parent::boot();

    static::saving(function ($nota) {
        // Calcular média trimestral: (MAC + Prova) / 2
        if ($nota->avaliacao_continua !== null && $nota->prova_trimestral !== null) {
            $nota->media_trimestral = round(
                ($nota->avaliacao_continua + $nota->prova_trimestral) / 2, 
                2
            );
        }

        // Calcular média final
        if ($nota->exame_final !== null && $nota->exame_final > 0 && $nota->media_trimestral !== null) {
            // Se tem exame, média = (media_trimestral + exame) / 2
            $nota->media_final = round(
                ($nota->media_trimestral + $nota->exame_final) / 2, 
                2
            );
        } else {
            // Se não tem exame, média final = média trimestral
            $nota->media_final = $nota->media_trimestral;
        }

        // Definir situação automática
        $media = $nota->media_final ?? $nota->media_trimestral ?? 0;
        
        if ($media >= 10) {
            $nota->situacao = 'aprovado';
        } elseif ($media >= 7) {
            $nota->situacao = 'exame';
        } else {
            $nota->situacao = 'reprovado';
        }
    });
}
    // ==================== RELACIONAMENTOS ====================
    public function matricula()
    {
        return $this->belongsTo(Matricula::class);
    }

    public function disciplina()
    {
        return $this->belongsTo(Disciplina::class);
    }

    // ==================== ACCESSORS ====================
    public function getStatusFormatadoAttribute(): string
    {
        return match($this->situacao) {
            'aprovado' => ' Aprovado',
            'reprovado' => ' Reprovado',
            'exame' => ' Em Exame',
            default => '📖 Cursando',
        };
    }

    public function getMediaFinalFormatadaAttribute(): string
    {
        return number_format($this->media_final ?? $this->media_trimestral ?? 0, 1);
    }
}