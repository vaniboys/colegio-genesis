<?php

namespace App\Filament\Resources\Alunos\Schemas;

use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;

class AlunoForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Section::make('Dados Pessoais')
                    ->schema([
                        TextInput::make('processo')
                            ->label('Nº Processo')
                            ->disabled()
                            ->dehydrated()
                            ->hidden(fn ($context) => $context === 'create')  // ✅ Oculta ao criar
                            ->maxLength(255),

                        TextInput::make('nome_completo')
                            ->label('Nome Completo')
                            ->required()
                            ->maxLength(255),

                        DatePicker::make('data_nascimento')
                            ->label('Data de Nascimento')
                            ->required(),

                        Select::make('sexo')
                            ->options(['M' => 'Masculino', 'F' => 'Feminino'])
                            ->required(),

                        TextInput::make('bi')
                            ->label('Nº do BI')
                            ->required()
                            ->unique(ignoreRecord: true),
                    ])->columns(2),

                Section::make('Contactos')
                    ->schema([
                        TextInput::make('telefone')
                            ->tel()
                            ->label('Telefone'),

                        TextInput::make('email')
                            ->email()
                            ->label('Email'),

                        Textarea::make('endereco')
                            ->label('Endereço')
                            ->required()
                            ->columnSpanFull(),

                        TextInput::make('municipio')
                            ->label('Município')
                            ->required(),
                    ])->columns(2),

                Section::make('Situação')
                    ->schema([
                        Select::make('situacao')
                            ->options([
                                'inactivo' => 'Inactivo',
                                'activo' => 'Activo',
                                'transferido' => 'Transferido',
                            ])
                            ->default('inactivo')
                            ->required()
                            ->disabled()
                            ->dehydrated()
                            ->helperText('Ativado automaticamente após matrícula.'),
                    ]),
            ]);
    }
}