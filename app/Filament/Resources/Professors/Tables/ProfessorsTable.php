<?php

namespace App\Filament\Resources\Professors\Tables;

use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;

class ProfessorsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nome_completo')
                    ->label('Nome')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('email')
                    ->label('Email')
                    ->searchable(),

                TextColumn::make('telefone')
                    ->label('Telefone'),

                TextColumn::make('especialidade')
                    ->label('Especialidade')
                    ->searchable(),

                TextColumn::make('data_contratacao')
                    ->label('Contratação')
                    ->date('d/m/Y')
                    ->sortable(),

                TextColumn::make('situacao')
                    ->label('Situação'),

                TextColumn::make('created_at')
                    ->label('Criado em')
                    ->dateTime('d/m/Y')
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                DeleteBulkAction::make(),
            ])
            ->defaultSort('nome_completo', 'asc');
    }
}