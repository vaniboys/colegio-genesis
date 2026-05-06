<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Encarregado extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'encarregados';
    
    protected $fillable = [
        'nome_completo',
        'telefone',
        'email',
        'parentesco',
        'endereco',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // ==================== RELACIONAMENTOS ====================
    
    public function alunos()
    {
        return $this->hasMany(Aluno::class);
    }

    // ==================== ACCESSORS ====================
    
    public function getNomeCompletoUpperAttribute(): string
    {
        return mb_strtoupper($this->nome_completo);
    }
}