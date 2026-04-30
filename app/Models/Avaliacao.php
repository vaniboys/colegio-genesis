<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Avaliacao extends Model
{
    protected $table = 'avaliacoes';
    
    protected $fillable = [
        'titulo', 'descricao', 'arquivo', 'tipo', 'turma_id', 'professor_id',
        'data_entrega', 'hora_limite', 'duracao', 'pontuacao_maxima', 'publicado'
    ];

    protected $casts = [
        'data_entrega' => 'date',
        'publicado' => 'boolean'
    ];

    public function turma()
    {
        return $this->belongsTo(Turma::class);
    }

    public function professor()
    {
        return $this->belongsTo(Professor::class);
    }

    public function questoes()
    {
        return $this->hasMany(Questao::class);
    }
}