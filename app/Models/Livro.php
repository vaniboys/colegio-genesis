<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Livro extends Model
{
    protected $table = 'livros';
    
    protected $fillable = [
        'titulo', 'autor', 'editora', 'isbn', 'disciplina_id', 'turma_id',
        'ano_publicacao', 'descricao', 'capa', 'arquivo_pdf', 'visualizacoes', 
        'downloads', 'ativo'
    ];

    protected $casts = [
        'ativo' => 'boolean',
        'ano_publicacao' => 'integer',
    ];

    // Relacionamentos
    public function disciplina()
    {
        return $this->belongsTo(Disciplina::class);
    }

    public function turma()
    {
        return $this->belongsTo(Turma::class);
    }

    // Scopes
    public function scopeAtivo($query)
    {
        return $query->where('ativo', true);
    }

    public function scopePorDisciplina($query, $disciplinaId)
    {
        return $query->where('disciplina_id', $disciplinaId);
    }

    public function scopePorTurma($query, $turmaId)
    {
        return $query->where('turma_id', $turmaId);
    }
}