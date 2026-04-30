<?php

namespace App\Filament\Resources\Notas\Tables;

use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;

class NotasTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('matricula.numero_matricula')
                    ->label('Nº Matrícula')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('matricula.aluno.nome_completo')
                    ->label('Aluno')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('disciplina.nome')
                    ->label('Disciplina')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('trimestre')
                    ->label('Trim.')
                    ->formatStateUsing(fn(int $state): string => $state . 'º'),

                TextColumn::make('avaliacao_continua')
                    ->label('MAC'),

                TextColumn::make('prova_trimestral')
                    ->label('Prova'),

                TextColumn::make('media_trimestral')
                    ->label('Média'),

                TextColumn::make('exame_final')
                    ->label('Exame')
                    ->toggleable(),

                TextColumn::make('media_final')
                    ->label('Média Final')
                    ->toggleable(),

                TextColumn::make('faltas')
                    ->label('Faltas'),

                TextColumn::make('situacao')
                    ->label('Situação')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'aprovado' => 'success',
                        'reprovado' => 'danger',
                        'exame' => 'warning',
                        default => 'gray',
                    }),
            ])
            ->filters([
                SelectFilter::make('disciplina_id')
                    ->relationship('disciplina', 'nome')
                    ->label('Disciplina'),

                SelectFilter::make('trimestre')
                    ->label('Trimestre')
                    ->options([
                        1 => '1º Trimestre',
                        2 => '2º Trimestre',
                        3 => '3º Trimestre',
                    ]),

                SelectFilter::make('situacao')
                    ->label('Situação')
                    ->options([
                        'cursando' => 'Cursando',
                        'aprovado' => 'Aprovado',
                        'reprovado' => 'Reprovado',
                        'exame' => 'Em Exame',
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