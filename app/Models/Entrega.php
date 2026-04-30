<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Entrega extends Model
{
    protected $table = 'entregas';
    
    protected $fillable = [
        'tarefa_id',      // ADICIONAR ESTE
        'aluno_id', 
        'arquivo', 
        'comentario', 
        'data_entrega', 
        'nota', 
        'feedback', 
        'status'
    ];

    public function tarefa()
    {
        return $this->belongsTo(Tarefa::class);
    }

    public function aluno()
    {
        return $this->belongsTo(Aluno::class);
    }
}