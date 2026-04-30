<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Spatie\Permission\Models\Role;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->schema([
                TextInput::make('name')
                    ->label('Nome')
                    ->required()
                    ->maxLength(255),

                TextInput::make('email')
                    ->label('Email')
                    ->email()
                    ->required()
                    ->unique(ignoreRecord: true),

                TextInput::make('password')
                    ->label('Senha')
                    ->password()
                    ->required(fn ($context) => $context === 'create')
                    ->minLength(6)
                    ->dehydrated(fn ($state) => filled($state)),

                // Seleciona uma role (exibindo nome amigável)
                Select::make('roles')
                    ->label('Perfil')
                    ->relationship('roles', 'name')
                    ->options(function () {
                        return Role::pluck('name', 'id')->toArray();
                    })
                    ->required()
                    ->preload()
                    ->searchable(),

                TextInput::make('telefone')
                    ->label('Telefone')
                    ->tel()
                    ->nullable(),
            ]);
    }
}