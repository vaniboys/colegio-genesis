<?php

namespace App\Filament\Resources\Turmas\Tables;

use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;

class TurmasTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nome')
                    ->label('Nome')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('classe.nome')
                    ->label('Classe')
                    ->sortable(),

                TextColumn::make('nivelEnsino.nome')
                    ->label('Nível'),

                TextColumn::make('curso.nome')
                    ->label('Curso'),

                TextColumn::make('turno')
                    ->label('Turno'),

                TextColumn::make('anoLectivo.ano')
                    ->label('Ano'),

                TextColumn::make('capacidade_maxima')
                    ->label('Capacidade'),

                TextColumn::make('vagas_ocupadas')
                    ->label('Ocupadas'),

                TextColumn::make('estado')
                    ->label('Estado'),

                TextColumn::make('created_at')
                    ->label('Criado em')
                    ->dateTime('d/m/Y')
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            
            
            ->defaultSort('nome', 'asc');
    }
}