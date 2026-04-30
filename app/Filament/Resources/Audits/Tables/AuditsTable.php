<?php

namespace App\Filament\Resources\Audits\Tables;

use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;

class AuditsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->label('#')->sortable(),
                TextColumn::make('user.name')->label('Utilizador')->searchable(),
                TextColumn::make('event')
                    ->label('Evento')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'created' => 'success',
                        'updated' => 'warning',
                        'deleted' => 'danger',
                        default => 'gray',
                    }),
                TextColumn::make('auditable_type')
    ->label('Tipo')
    ->formatStateUsing(fn ($state) => $state ? class_basename($state) : 'Sistema'),
                TextColumn::make('created_at')
                    ->label('Data')
                    ->dateTime('d/m/Y H:i:s')
                    ->sortable(),
                TextColumn::make('ip_address')
                    ->label('IP')
                    ->toggleable(),
            ])
            ->defaultSort('created_at', 'desc');
    }
}