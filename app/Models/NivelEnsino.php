<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NivelEnsino extends Model
{
    // 🔥 CORREÇÃO PRINCIPAL
    protected $table = 'niveis_ensino';

    protected $fillable = [
        'nome',
        'codigo',
        'classe_inicio',
        'classe_fim',
        'duracao_anos',
        'ativo',
    ];
}