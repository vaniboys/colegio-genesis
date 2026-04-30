<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

class Curso extends Model implements Auditable
{
    use AuditableTrait;
    
    protected $table = 'cursos';
    
    protected $fillable = [
        'codigo',
        'nome',
        'descricao',
        'ativo',
    ];
}