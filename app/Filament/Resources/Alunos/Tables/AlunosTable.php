<?php

namespace App\Filament\Resources\Alunos\Tables;

use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;

class AlunosTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('foto')
                    ->label('Foto')
                    ->circular()
                    ->defaultImageUrl(fn ($record) => 'https://ui-avatars.com/api/?background=0D8ABC&color=fff&name=' . urlencode($record->nome_completo))
                    ->toggleable(),

                TextColumn::make('processo')
                    ->label('Nº Processo')
                    ->searchable()
                    ->sortable()
                    ->copyable()
                    ->copyMessage('Processo copiado'),

                TextColumn::make('nome_completo')
                    ->label('Nome Completo')
                    ->searchable()
                    ->sortable()
                    ->description(fn ($record) => $record->bi ?? 'Sem BI'),

                TextColumn::make('data_nascimento')
                    ->label('Idade')
                    ->formatStateUsing(fn ($record) => $record->data_nascimento?->age . ' anos')
                    ->toggleable()
                    ->sortable(),

                TextColumn::make('sexo')
                    ->label('Sexo')
                    ->badge()
                    ->color(fn (string $state): string => $state === 'M' ? 'primary' : 'danger')
                    ->formatStateUsing(fn (string $state): string => $state === 'M' ? 'Masculino' : 'Feminino')
                    ->toggleable(),

                TextColumn::make('telefone')
                    ->label('Telefone')
                    ->toggleable()
                    ->copyable(),

                TextColumn::make('email')
                    ->label('Email')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->copyable(),

                TextColumn::make('encarregado.nome_completo')
                    ->label('Encarregado')
                    ->toggleable()
                    ->searchable()
                    ->placeholder('Não definido'),

                TextColumn::make('situacao')
                    ->label('Situação')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'activo' => 'success',
                        'inactivo' => 'danger',
                        'transferido' => 'warning',
                        'desistente' => 'gray',
                        'concluido' => 'info',
                        default => 'gray',
                    })
                    ->icon(fn (string $state): string => match ($state) {
                        'activo' => 'heroicon-m-check-circle',
                        'inactivo' => 'heroicon-m-x-circle',
                        'transferido' => 'heroicon-m-arrow-path',
                        'desistente' => 'heroicon-m-minus-circle',
                        'concluido' => 'heroicon-m-academic-cap',
                        default => 'heroicon-m-question-mark-circle',
                    }),

                TextColumn::make('created_at')
                    ->label('Cadastro')
                    ->dateTime('d/m/Y')
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('updated_at')
                    ->label('Atualização')
                    ->dateTime('d/m/Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('situacao')
                    ->label('Situação')
                    ->options([
                        'activo' => 'Activo',
                        'inactivo' => 'Inactivo',
                        'transferido' => 'Transferido',
                        'desistente' => 'Desistente',
                        'concluido' => 'Concluído',
                    ])
                    ->native(false),

                SelectFilter::make('sexo')
                    ->label('Sexo')
                    ->options(['M' => 'Masculino', 'F' => 'Feminino'])
                    ->native(false),

                SelectFilter::make('provincia_id')
                    ->label('Província')
                    ->relationship('provincia', 'nome')
                    ->searchable()
                    ->preload()
                    ->native(false),

                TernaryFilter::make('tem_encarregado')
                    ->label('Tem Encarregado?')
                    ->placeholder('Todos')
                    ->trueLabel('Com Encarregado')
                    ->falseLabel('Sem Encarregado')
                    ->queries(
                        true: fn ($query) => $query->whereNotNull('encarregado_id'),
                        false: fn ($query) => $query->whereNull('encarregado_id'),
                    ),

                TernaryFilter::make('tem_email')
                    ->label('Tem Email?')
                    ->placeholder('Todos')
                    ->trueLabel('Com Email')
                    ->falseLabel('Sem Email')
                    ->queries(
                        true: fn ($query) => $query->whereNotNull('email'),
                        false: fn ($query) => $query->whereNull('email'),
                    ),
            ])
            
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
            ])

            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    Action::make('bulk_restore')
                        ->label('Restaurar selecionados')
                        ->icon('heroicon-m-arrow-path')
                        ->color('success')
                        ->requiresConfirmation()
                        ->action(fn ($records) => $records->each->restore()),
                ]),
            ])

            ->defaultSort('created_at', 'desc')
            ->striped()
            ->persistFiltersInSession()
            ->persistSearchInSession()
            ->paginated([10, 25, 50, 100]);
    }
}