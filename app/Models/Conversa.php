<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Conversa extends Model
{
    protected $table = 'conversas'; // Nome correto da tabela
    
    protected $fillable = ['user_1_id', 'user_2_id', 'titulo', 'ultima_mensagem'];
    
    protected $casts = [
        'ultima_mensagem' => 'datetime'
    ];

    public function user1()
    {
        return $this->belongsTo(User::class, 'user_1_id');
    }

    public function user2()
    {
        return $this->belongsTo(User::class, 'user_2_id');
    }

    public function mensagens()
    {
        return $this->hasMany(Mensagem::class);
    }

    public function getOutroUserAttribute()
    {
        return auth()->id() == $this->user_1_id ? $this->user2 : $this->user1;
    }
}