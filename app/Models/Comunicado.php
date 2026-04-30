<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comunicado extends Model
{
    protected $table = 'comunicados';
    
    protected $fillable = [
        'titulo', 'mensagem', 'professor_id', 'turma_id', 'arquivo', 'para_todos'
    ];

    public function professor()
    {
        return $this->belongsTo(Professor::class);
    }

    public function turma()
    {
        return $this->belongsTo(Turma::class);
    }
}