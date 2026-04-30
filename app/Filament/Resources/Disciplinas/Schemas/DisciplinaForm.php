<?php

namespace App\Filament\Resources\Disciplinas\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use App\Models\Classe;

class DisciplinaForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->schema([
                TextInput::make('nome')
                    ->label('Nome da Disciplina')
                    ->required()
                    ->maxLength(255),

                TextInput::make('codigo')
                    ->label('Código')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(10),

                TextInput::make('carga_horaria')
                    ->label('Carga Horária Total')
                    ->numeric()
                    ->required()
                    ->default(2),

                Select::make('classes')
                    ->label('Classes')
                    ->multiple()
                    ->relationship('classes', 'nome')
                    ->preload()
                    ->options(function () {
                        return Classe::with('nivelEnsino')
                            ->get()
                            ->mapWithKeys(function ($classe) {
                                return [$classe->id => $classe->nome . ' (' . ($classe->nivelEnsino->nome ?? 'N/A') . ')'];
                            });
                    }),
            ]);
    }
}