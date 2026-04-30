<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Traits\HasRoles;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;

class User extends Authenticatable implements FilamentUser, Auditable
{
    use Notifiable, HasRoles, AuditableTrait;

    //  ESSENCIAL PARA SPATIE
    protected string $guard_name = 'web';

    protected $fillable = [
        'name',
        'email',
        'password',
        'telefone',
        'foto',
        'ativo',
        'ultimo_acesso',
        'professor_id',
        'aluno_id'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'ultimo_acesso' => 'datetime',
        'ativo' => 'boolean',
    ];

    // =========================================
    //  RELACIONAMENTOS
    // =========================================

    public function aluno()
    {
        return $this->belongsTo(\App\Models\Aluno::class, 'aluno_id');
    }

    public function professor()
    {
        return $this->belongsTo(\App\Models\Professor::class, 'professor_id');
    }

    // =========================================
    //  CONTROLO DE ACESSO AO FILAMENT
    // =========================================

    public function canAccessPanel(Panel $panel): bool
    {
        return match ($panel->getId()) {
            'admin' => $this->hasRole('admin'),
            'professor' => $this->hasRole('professor'),
            'portal' => $this->hasRole('aluno'),
            default => false,
        };
    }

    // =========================================
    //  HELPERS
    // =========================================

    public function isAdmin(): bool
    {
        return $this->hasRole('admin');
    }

    public function isProfessor(): bool
    {
        return $this->hasRole('professor');
    }

    public function isAluno(): bool
    {
        return $this->hasRole('aluno');
    }

    // =========================================
    //  AUTO HASH PASSWORD
    // =========================================

    public function setPasswordAttribute($value)
    {
        if (!Hash::needsRehash($value)) {
            $this->attributes['password'] = $value;
            return;
        }

        $this->attributes['password'] = Hash::make($value);
    }
}