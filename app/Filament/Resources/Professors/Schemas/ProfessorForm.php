<?php

namespace App\Filament\Resources\Professors\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;

class ProfessorForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->schema([
                TextInput::make('nome_completo')
                    ->label('Nome Completo')
                    ->required()
                    ->maxLength(255),

                TextInput::make('email')
                    ->label('Email')
                    ->email()
                    ->required()
                    ->unique(ignoreRecord: true),

                TextInput::make('bi')
                    ->label('Nº do BI')
                    ->required()
                    ->unique(ignoreRecord: true),

                TextInput::make('telefone')
                    ->label('Telefone')
                    ->tel()
                    ->required(),

                TextInput::make('especialidade')
                    ->label('Especialidade')
                    ->required(),

                Textarea::make('habilitacoes')
                    ->label('Habilitações')
                    ->rows(3),

                //  DATA AUTOMÁTICA E OCULTA
                DatePicker::make('data_contratacao')
                    ->label('Data de Contratação')
                    ->default(now())
                    ->hidden()
                    ->required(),

                Select::make('situacao')
                    ->label('Situação')
                    ->options([
                        'activo' => 'Activo',
                        'inactivo' => 'Inactivo',
                        'licenca' => 'Licença',
                    ])
                    ->default('activo')
                    ->required(),
            ]);
    }
}