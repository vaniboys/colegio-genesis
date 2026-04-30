<?php

namespace App\Filament\Resources\Notas\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;

class NotaForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Select::make('matricula_id')
                    ->label('Matrícula')
                    ->relationship('matricula', 'numero_matricula')
                    ->searchable()
                    ->preload()
                    ->required(),

                Select::make('disciplina_id')
                    ->label('Disciplina')
                    ->relationship('disciplina', 'nome')
                    ->searchable()
                    ->preload()
                    ->required(),

                Select::make('trimestre')
                    ->label('Trimestre')
                    ->options([
                        1 => '1º Trimestre',
                        2 => '2º Trimestre',
                        3 => '3º Trimestre',
                    ])
                    ->required(),

                TextInput::make('avaliacao_continua')
                    ->label('Avaliação Contínua (MAC)')
                    ->numeric()
                    ->minValue(0)
                    ->maxValue(20)
                    ->required(),

                TextInput::make('prova_trimestral')
                    ->label('Prova Trimestral')
                    ->numeric()
                    ->minValue(0)
                    ->maxValue(20)
                    ->required(),

                TextInput::make('media_trimestral')
                    ->label('Média Trimestral')
                    ->numeric()
                    ->disabled()
                    ->dehydrated(),

                TextInput::make('exame_final')
                    ->label('Exame Final')
                    ->numeric()
                    ->minValue(0)
                    ->maxValue(20)
                    ->nullable(),

                TextInput::make('media_final')
                    ->label('Média Final')
                    ->numeric()
                    ->disabled()
                    ->dehydrated(),

                TextInput::make('faltas')
                    ->label('Faltas')
                    ->numeric()
                    ->default(0),

                Select::make('situacao')
                    ->label('Situação')
                    ->options([
                        'cursando' => 'Cursando',
                        'aprovado' => 'Aprovado',
                        'reprovado' => 'Reprovado',
                        'exame' => 'Em Exame',
                    ])
                    ->default('cursando'),

                Textarea::make('observacoes')
                    ->label('Observações')
                    ->nullable(),
            ]);
    }
}