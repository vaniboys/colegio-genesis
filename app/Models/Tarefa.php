<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tarefa extends Model
{
    protected $table = 'tarefas'; // Nome correto da tabela
    
    protected $fillable = [
        'titulo', 'descricao', 'turma_id', 'professor_id',
        'data_entrega', 'pontuacao_maxima', 'arquivo', 'publicado'
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

    public function entregas()
    {
        return $this->hasMany(Entrega::class);
    }
}