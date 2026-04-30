<?php

namespace App\Filament\Resources\ProfessorTurmaDisciplinas\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;

class ProfessorTurmaDisciplinaForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Select::make('professor_id')
                    ->relationship('professor', 'nome_completo')
                    ->label('Professor')
                    ->searchable()
                    ->preload()
                    ->required(),

                Select::make('turma_id')
                    ->relationship('turma', 'nome')
                    ->label('Turma')
                    ->searchable()
                    ->preload()
                    ->required(),

                Select::make('disciplina_id')
                    ->relationship('disciplina', 'nome')
                    ->label('Disciplina')
                    ->searchable()
                    ->preload()
                    ->required(),

                Select::make('ano_lectivo_id')
                    ->relationship('anoLectivo', 'ano')
                    ->label('Ano Lectivo')
                    ->nullable(),

                TextInput::make('carga_horaria')
                    ->label('Carga Horária')
                    ->numeric()
                    ->default(2),

                Toggle::make('ativo')
                    ->label('Ativo')
                    ->default(true),
            ]);
    }
}