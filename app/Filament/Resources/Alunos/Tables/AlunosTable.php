<?php

namespace App\Filament\Resources\Alunos\Tables;

use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;

class AlunosTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('processo')
                    ->label('Nº Processo')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('nome_completo')
                    ->label('Nome')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('bi')
                    ->label('BI')
                    ->searchable()
                    ->toggleable(),

                TextColumn::make('telefone')
                    ->label('Telefone')
                    ->toggleable(),

                TextColumn::make('email')
                    ->label('Email')
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('sexo')
                    ->label('Sexo')
                    ->badge(),

                TextColumn::make('situacao')
                    ->label('Situação')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'activo' => 'success',
                        'inactivo' => 'danger',
                        'transferido' => 'warning',
                        default => 'gray',
                    }),

                TextColumn::make('created_at')
                    ->label('Criado em')
                    ->dateTime('d/m/Y')
                    ->sortable()
                    ->toggleable(),
            ])
            ->filters([
                SelectFilter::make('situacao')
                    ->label('Situação')
                    ->options([
                        'activo' => 'Activo',
                        'inactivo' => 'Inactivo',
                        'transferido' => 'Transferido',
                    ]),
                SelectFilter::make('sexo')
                    ->label('Sexo')
                    ->options(['M' => 'Masculino', 'F' => 'Feminino']),
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                DeleteBulkAction::make(),
            ])
            ->defaultSort('created_at', 'desc');
    }
}