<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    protected $table = 'materiais'; // Nome correto da tabela
    
    protected $fillable = [
        'titulo', 'descricao', 'arquivo', 'tipo',
        'turma_id', 'professor_id', 'visualizacoes', 'downloads'
    ];

    public function turma()
    {
        return $this->belongsTo(Turma::class);
    }

    public function professor()
    {
        return $this->belongsTo(Professor::class);
    }
}