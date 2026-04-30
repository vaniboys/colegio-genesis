<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Questao extends Model
{
    protected $table = 'questoes'; // Nome correto da tabela
    
    protected $fillable = [
        'avaliacao_id', 'pergunta', 'tipo', 'opcoes', 'resposta_correta', 'pontos'
    ];

    protected $casts = [
        'opcoes' => 'array'
    ];

    public function avaliacao()
    {
        return $this->belongsTo(Avaliacao::class);
    }

    public function respostas()
    {
        return $this->hasMany(Resposta::class);
    }
}