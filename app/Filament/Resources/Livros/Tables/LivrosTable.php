<?php

namespace App\Filament\Resources\Livros\Tables;

use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;

class LivrosTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('capa')
                    ->label('Capa')
                    ->circular()
                    ->width(50)
                    ->height(50)
                    ->defaultImageUrl(asset('images/livro-placeholder.png')),
                
                TextColumn::make('titulo')
                    ->label('Título')
                    ->searchable()
                    ->sortable()
                    ->limit(40),
                
                TextColumn::make('autor')
                    ->label('Autor')
                    ->searchable()
                    ->limit(30),
                
                TextColumn::make('editora')
                    ->label('Editora')
                    ->searchable()
                    ->limit(30),
                
                TextColumn::make('disciplina.nome')
                    ->label('Disciplina')
                    ->sortable(),
                
                TextColumn::make('turma.nome')
                    ->label('Turma')
                    ->sortable()
                    ->default('—'),
                
                TextColumn::make('ano_publicacao')
                    ->label('Ano')
                    ->sortable(),
                
                TextColumn::make('downloads')
                    ->label('Downloads')
                    ->sortable()
                    ->numeric()
                    ->badge()
                    ->color('info'),
                
                IconColumn::make('ativo')
                    ->label('Ativo')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger'),
                
                TextColumn::make('created_at')
                    ->label('Criado em')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('disciplina_id')
                    ->label('Disciplina')
                    ->relationship('disciplina', 'nome'),
                
                SelectFilter::make('ativo')
                    ->label('Status')
                    ->options([
                        '1' => 'Ativo',
                        '0' => 'Inativo',
                    ]),
            ])
            
          
            ->defaultSort('created_at', 'desc');
    }
}