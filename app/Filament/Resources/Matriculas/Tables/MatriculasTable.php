<?php

namespace App\Filament\Resources\Matriculas\Tables;

use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;

class MatriculasTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('numero_matricula')
                    ->label('Nº Matrícula')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('aluno.nome_completo')
                    ->label('Aluno')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('aluno.bi')
                    ->label('BI')
                    ->searchable()
                    ->toggleable(),

                TextColumn::make('turma.nome')
                    ->label('Turma')
                    ->searchable(),

                TextColumn::make('turma.turno')
                    ->label('Turno')
                    ->toggleable(),

                TextColumn::make('anoLectivo.ano')
                    ->label('Ano Lectivo'),

                TextColumn::make('tipo')
                    ->label('Tipo')
                    ->badge()
                    ->toggleable(),

                TextColumn::make('situacao')
                    ->label('Situação')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'ativa' => 'success',
                        'pendente' => 'warning',
                        'cancelada' => 'danger',
                        'concluida' => 'primary',
                        default => 'gray',
                    }),

                TextColumn::make('data_matricula')
                    ->label('Data')
                    ->date('d/m/Y')
                    ->sortable(),

                TextColumn::make('created_at')
                    ->label('Criado em')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('situacao')
                    ->label('Situação')
                    ->options([
                        'ativa' => 'Ativa',
                        'pendente' => 'Pendente',
                        'cancelada' => 'Cancelada',
                        'concluida' => 'Concluída',
                    ]),
                SelectFilter::make('turma_id')
                    ->label('Turma')
                    ->relationship('turma', 'nome'),
                SelectFilter::make('ano_lectivo_id')
                    ->label('Ano Lectivo')
                    ->relationship('anoLectivo', 'ano'),
                SelectFilter::make('tipo')
                    ->label('Tipo')
                    ->options([
                        'nova' => 'Nova',
                        'renovacao' => 'Renovação',
                        'transferencia' => 'Transferência',
                    ]),
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