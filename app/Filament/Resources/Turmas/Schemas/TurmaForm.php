<?php

namespace App\Filament\Resources\Turmas\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Hidden;

class TurmaForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->schema([
                TextInput::make('nome')
                    ->label('Nome da Turma')
                    ->hint('Deixe em branco para gerar automaticamente')
                    ->maxLength(255),

                Select::make('nivel_ensino_id')
                    ->relationship('nivelEnsino', 'nome')
                    ->label('Nível de Ensino')
                    ->required()
                    ->live(),

                Select::make('curso_id')
                    ->relationship('curso', 'nome')
                    ->label('Curso')
                    ->nullable(),

                Select::make('turno')
                    ->label('Turno')
                    ->options([
                        'manha' => 'Manhã',
                        'tarde' => 'Tarde',
                        'noite' => 'Noite',
                    ])
                    ->default('manha')
                    ->required(),

                Select::make('ano_lectivo_id')
                    ->relationship('anoLectivo', 'ano')
                    ->label('Ano Lectivo')
                    ->required(),

                TextInput::make('capacidade_maxima')
                    ->label('Capacidade Máxima')
                    ->numeric()
                    ->default(40)
                    ->required(),

                Select::make('estado')
                    ->label('Estado')
                    ->options([
                        'ativa' => 'Ativa',
                        'inativa' => 'Inativa',
                    ])
                    ->default('ativa')
                    ->required(),
            ]);
    }
}