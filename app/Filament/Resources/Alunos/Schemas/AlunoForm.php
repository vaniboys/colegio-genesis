<?php

namespace App\Filament\Resources\Alunos\Schemas;

use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\FileUpload;

class AlunoForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Tabs::make('Registo do Aluno')
                    ->tabs([
                        // ==================== ABA 1: DADOS PESSOAIS ====================
                        Tabs\Tab::make('Dados Pessoais')
                            ->icon('heroicon-o-user')
                            ->schema([
                                Section::make('Identificação')
                                    ->schema([
                                        TextInput::make('processo')
                                            ->label('Nº Processo')
                                            ->disabled()
                                            ->dehydrated()
                                            ->hidden(fn ($context) => $context === 'create')
                                            ->maxLength(255)
                                            ->helperText('Gerado automaticamente')
                                            ->columnSpan(1),

                                        TextInput::make('nome_completo')
                                            ->label('Nome Completo')
                                            ->required()
                                            ->maxLength(255)
                                            ->columnSpan(2),

                                        DatePicker::make('data_nascimento')
                                            ->label('Data de Nascimento')
                                            ->required()
                                            ->displayFormat('d/m/Y')
                                            ->columnSpan(1),

                                        Select::make('sexo')
                                            ->label('Sexo')
                                            ->options(['M' => 'Masculino', 'F' => 'Feminino'])
                                            ->required()
                                            ->columnSpan(1),

                                        TextInput::make('bi')
                                            ->label('Nº do BI')
                                            ->nullable()
                                            ->unique(ignoreRecord: true)
                                            ->maxLength(20)
                                            ->columnSpan(2),

                                        FileUpload::make('foto')
                                            ->label('Foto')
                                            ->image()
                                            ->imageEditor()
                                            ->circleCropper()
                                            ->directory('alunos/fotos')
                                            ->maxSize(2048)
                                            ->columnSpan(2),
                                    ])
                                    ->columns(2)
                                    ->collapsible(),

                                Section::make('Observações')
                                    ->schema([
                                        Textarea::make('observacoes')
                                            ->label('Observações')
                                            ->rows(3)
                                            ->columnSpanFull(),
                                    ]),
                            ]),

                        // ==================== ABA 2: CONTACTOS E ENDEREÇO ====================
                        Tabs\Tab::make('Contactos e Endereço')
                            ->icon('heroicon-o-phone')
                            ->schema([
                                Section::make('Contactos')
                                    ->schema([
                                        TextInput::make('telefone')
                                            ->label('Telefone')
                                            ->tel()
                                            ->maxLength(15)
                                            ->columnSpan(1),

                                        TextInput::make('email')
                                            ->label('Email')
                                            ->email()
                                            ->maxLength(255)
                                            ->columnSpan(1),
                                    ])
                                    ->columns(2),

                                Section::make('Morada')
                                    ->schema([
                                        Textarea::make('endereco')
                                            ->label('Endereço')
                                            ->required()
                                            ->rows(2)
                                            ->columnSpanFull(),

                                        TextInput::make('municipio')
                                            ->label('Município')
                                            ->required()
                                            ->maxLength(100)
                                            ->columnSpan(1),

                                        Select::make('provincia_id')
                                            ->label('Província')
                                            ->relationship('provincia', 'nome')
                                            ->searchable()
                                            ->preload()
                                            ->placeholder('Selecione a província')
                                            ->columnSpan(1),
                                    ])
                                    ->columns(2),
                            ]),

                        // ==================== ABA 3: RESPONSÁVEL ====================
                        Tabs\Tab::make('Encarregado')
                            ->icon('heroicon-o-users')
                            ->schema([
                                Section::make('Dados do Encarregado')
                                    ->schema([
                                        Select::make('encarregado_id')
                                            ->label('Encarregado de Educação')
                                            ->relationship('encarregado', 'nome_completo')
                                            ->searchable()
                                            ->preload()
                                            ->placeholder('Selecione um encarregado')
                                            ->createOptionForm([
                                                TextInput::make('nome_completo')
                                                    ->label('Nome Completo')
                                                    ->required()
                                                    ->maxLength(255),
                                                    
                                                TextInput::make('telefone')
                                                    ->label('Telefone')
                                                    ->tel()
                                                    ->maxLength(15),
                                                    
                                                TextInput::make('email')
                                                    ->label('Email')
                                                    ->email()
                                                    ->maxLength(255),
                                                    
                                                TextInput::make('parentesco')
                                                    ->label('Parentesco')
                                                    ->maxLength(100)
                                                    ->placeholder('Ex: Pai, Mãe, Tio, Avó...'),
                                                    
                                                Textarea::make('endereco')
                                                    ->label('Endereço')
                                                    ->rows(2)
                                                    ->maxLength(500),
                                            ])
                                            ->createOptionAction(function ($action) {
                                                return $action
                                                    ->modalHeading('Novo Encarregado')
                                                    ->modalWidth('lg')
                                                    ->modalSubmitActionLabel('Criar Encarregado');
                                            })
                                            ->helperText('Selecione um encarregado existente ou crie um novo')
                                            ->columnSpanFull(),
                                    ]),
                            ]),

                        // ==================== ABA 4: SITUAÇÃO ====================
                        Tabs\Tab::make('Situação')
                            ->icon('heroicon-o-check-circle')
                            ->schema([
                                Section::make('Situação Académica')
                                    ->schema([
                                        Select::make('situacao')
                                            ->label('Situação')
                                            ->options([
                                                'inactivo' => 'Inactivo',
                                                'activo' => 'Activo',
                                                'transferido' => 'Transferido',
                                                'desistente' => 'Desistente',
                                                'concluido' => 'Concluído',
                                            ])
                                            ->default('inactivo')
                                            ->required()
                                            ->disabled(fn ($context) => $context === 'create')
                                            ->dehydrated()
                                            ->helperText('Ativado automaticamente após matrícula.')
                                            ->columnSpanFull(),
                                    ]),
                            ]),
                    ])
                    ->persistTab()
                    ->columnSpanFull(),
            ])
            ->columns(1);
    }
}