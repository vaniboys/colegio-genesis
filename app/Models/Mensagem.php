<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mensagem extends Model
{
    protected $table = 'mensagens';
    
    protected $fillable = ['conversa_id', 'user_id', 'mensagem', 'anexo', 'lida', 'lida_em'];
    
    protected $casts = [
        'lida' => 'boolean',
        'lida_em' => 'datetime'
    ];

    public function conversa()
    {
        return $this->belongsTo(Conversa::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}