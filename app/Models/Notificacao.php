<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notificacao extends Model
{
    protected $table = 'notificacoes'; // Nome correto da tabela
    
    protected $fillable = ['user_id', 'titulo', 'mensagem', 'tipo', 'link', 'lida'];
    
    protected $casts = [
        'lida' => 'boolean'
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function scopeNaoLidas($query)
    {
        return $query->where('lida', false);
    }
}