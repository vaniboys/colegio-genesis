<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Propina extends Model
{
    protected $table = 'propinas';
    
    protected $fillable = [
        'matricula_id', 'aluno_id', 'mes_referencia', 'ano_referencia',
        'valor', 'multa', 'desconto', 'valor_pago',
        'data_vencimento', 'data_pagamento', 'status',
        'metodo_pagamento', 'observacoes',
    ];

    protected $casts = [
        'data_vencimento' => 'date',
        'data_pagamento' => 'date',
        'valor' => 'decimal:2',
        'multa' => 'decimal:2',
        'desconto' => 'decimal:2',
        'valor_pago' => 'decimal:2',
    ];

    public function matricula()
    {
        return $this->belongsTo(Matricula::class);
    }

    public function aluno()
    {
        return $this->belongsTo(Aluno::class);
    }

    // Scopes
    public function scopePendente($query)
    {
        return $query->where('status', 'pendente');
    }

    public function scopeEmAtraso($query)
    {
        return $query->where('status', 'pendente')
            ->where('data_vencimento', '<', now());
    }

    public function scopePago($query)
    {
        return $query->where('status', 'pago');
    }
}