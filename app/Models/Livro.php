<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;
// use Illuminate\Database\Eloquent\SoftDeletes; // ← COMENTE OU REMOVA ESTA LINHA

class Livro extends Model implements Auditable
{
    use AuditableTrait;
    // use SoftDeletes; // ← REMOVA OU COMENTE ESTA LINHA
    
    protected $table = 'livros';
    
    protected $fillable = [
        'titulo',
        'autor',
        'editora',
        'isbn',
        'disciplina_id',
        'turma_id',
        'ano_publicacao',
        'descricao',
        'capa',
        'arquivo_pdf',
        'visualizacoes',
        'downloads',
        'ativo',
    ];
    
    protected $casts = [
        'ano_publicacao' => 'integer',
        'visualizacoes' => 'integer',
        'downloads' => 'integer',
        'ativo' => 'boolean',
    ];
    
    // ==================== RELACIONAMENTOS ====================
    
    public function disciplina()
    {
        return $this->belongsTo(Disciplina::class);
    }
    
    public function turma()
    {
        return $this->belongsTo(Turma::class);
    }
}