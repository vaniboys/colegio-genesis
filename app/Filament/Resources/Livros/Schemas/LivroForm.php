<?php

namespace App\Filament\Resources\Livros\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\DateTimePicker;
use App\Models\Disciplina;
use App\Models\Turma;

class LivroForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('titulo')
                    ->label('Título')
                    ->required()
                    ->maxLength(255),
                
                TextInput::make('autor')
                    ->label('Autor')
                    ->maxLength(255)
                    ->nullable(),
                
                TextInput::make('editora')
                    ->label('Editora')
                    ->maxLength(255)
                    ->nullable(),
                
                TextInput::make('isbn')
                    ->label('ISBN')
                    ->maxLength(20)
                    ->nullable(),
                
                Select::make('disciplina_id')
                    ->label('Disciplina')
                    ->options(Disciplina::all()->pluck('nome', 'id'))
                    ->searchable()
                    ->required(),
                
                Select::make('turma_id')
                    ->label('Turma (Opcional)')
                    ->options(
                        Turma::with('classe')
                            ->get()
                            ->mapWithKeys(fn($t) => [
                                $t->id => "{$t->nome} - {$t->classe?->nome}"
                            ])
                    )
                    ->searchable()
                    ->nullable(),
                
                TextInput::make('ano_publicacao')
                    ->label('Ano de Publicação')
                    ->numeric()
                    ->minValue(1900)
                    ->maxValue(date('Y'))
                    ->nullable(),
                
                Textarea::make('descricao')
                    ->label('Descrição')
                    ->rows(3)
                    ->maxLength(500)
                    ->nullable()
                    ->columnSpanFull(),
                
                FileUpload::make('capa')
                    ->label('Capa do Livro')
                    ->image()
                    ->directory('livros/capas')
                    ->imageResizeTargetWidth(200)
                    ->imageResizeTargetHeight(280)
                    ->nullable(),
                
                FileUpload::make('arquivo_pdf')
                    ->label('Arquivo PDF')
                    ->acceptedFileTypes(['application/pdf'])
                    ->directory('livros/pdfs')
                    ->nullable(),
                
                TextInput::make('visualizacoes')
                    ->label('Visualizações')
                    ->numeric()
                    ->default(0)
                    ->required()
                    ->disabled()
                    ->visible(false),
                
                TextInput::make('downloads')
                    ->label('Downloads')
                    ->numeric()
                    ->default(0)
                    ->required()
                    ->disabled()
                    ->visible(false),
                
                Toggle::make('ativo')
                    ->label('Ativo')
                    ->default(true)
                    ->required(),
            ]);
    }
}