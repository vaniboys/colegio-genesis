<?php

namespace App\Filament\Resources\Matriculas\Tables;

use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
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
                    ->sortable()
                    ->copyable()
                    ->copyMessage('Número de matrícula copiado')
                    ->icon('heroicon-m-document-duplicate'),

                TextColumn::make('aluno.nome_completo')
                    ->label('Aluno')
                    ->searchable()
                    ->sortable()
                    ->description(fn ($record) => $record->aluno?->processo ?? 'Sem processo'),

                TextColumn::make('aluno.bi')
                    ->label('BI')
                    ->searchable()
                    ->toggleable()
                    ->copyable(),

                TextColumn::make('turma.nome')
                    ->label('Turma')
                    ->searchable()
                    ->badge()
                    ->color('info'),

                TextColumn::make('turma.turno')
                    ->label('Turno')
                    ->toggleable()
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'manhã' => 'success',
                        'tarde' => 'warning',
                        'noite' => 'info',
                        default => 'gray',
                    }),

                TextColumn::make('anoLectivo.ano')
                    ->label('Ano Lectivo')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('tipo')
                    ->label('Tipo')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'nova' => 'success',
                        'renovacao' => 'info',
                        'transferencia' => 'warning',
                        default => 'gray',
                    })
                    ->icon(fn (string $state): string => match ($state) {
                        'nova' => 'heroicon-m-plus-circle',
                        'renovacao' => 'heroicon-m-arrow-path',
                        'transferencia' => 'heroicon-m-switch-horizontal',
                        default => 'heroicon-m-question-mark-circle',
                    })
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
                    })
                    ->icon(fn (string $state): string => match ($state) {
                        'ativa' => 'heroicon-m-check-circle',
                        'pendente' => 'heroicon-m-clock',
                        'cancelada' => 'heroicon-m-x-circle',
                        'concluida' => 'heroicon-m-academic-cap',
                        default => 'heroicon-m-question-mark-circle',
                    }),

                TextColumn::make('data_matricula')
                    ->label('Data Matrícula')
                    ->date('d/m/Y')
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('created_at')
                    ->label('Registrado em')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->since(),

                TextColumn::make('updated_at')
                    ->label('Atualizado em')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('situacao')
                    ->label('Situação')
                    ->options([
                        'ativa' => '🟢 Ativa',
                        'pendente' => '🟡 Pendente',
                        'cancelada' => '🔴 Cancelada',
                        'concluida' => '⚫ Concluída',
                    ])
                    ->native(false),

                SelectFilter::make('turma_id')
                    ->label('Turma')
                    ->relationship('turma', 'nome')
                    ->searchable()
                    ->preload()
                    ->native(false),

                SelectFilter::make('ano_lectivo_id')
                    ->label('Ano Lectivo')
                    ->relationship('anoLectivo', 'ano')
                    ->searchable()
                    ->preload()
                    ->native(false),

                SelectFilter::make('tipo')
                    ->label('Tipo')
                    ->options([
                        'nova' => '📝 Nova',
                        'renovacao' => '🔄 Renovação',
                        'transferencia' => '🚚 Transferência',
                    ])
                    ->native(false),

                TernaryFilter::make('tem_desconto')
                    ->label('Tem Desconto?')
                    ->placeholder('Todos')
                    ->trueLabel('Com Desconto')
                    ->falseLabel('Sem Desconto')
                    ->queries(
                        true: fn ($query) => $query->whereNotNull('desconto_id'),
                        false: fn ($query) => $query->whereNull('desconto_id'),
                    ),
            ])
            
            ->actions([
                Action::make('edit')
                    ->label('')
                    ->tooltip('Editar')
                    ->icon('heroicon-m-pencil-square')
                    ->color('warning')
                    ->url(fn ($record): string => route('filament.admin.resources.matriculas.edit', $record)),

                Action::make('delete')
                    ->label('')
                    ->tooltip('Excluir')
                    ->icon('heroicon-m-trash')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->action(fn ($record) => $record->delete()),
            ])

            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    Action::make('bulk_cancelar')
                        ->label('Cancelar selecionadas')
                        ->icon('heroicon-m-x-circle')
                        ->color('danger')
                        ->requiresConfirmation()
                        ->action(function ($records) {
                            $records->each(function ($record) {
                                if ($record->situacao === 'ativa' || $record->situacao === 'pendente') {
                                    $record->update(['situacao' => 'cancelada']);
                                }
                            });
                            \Filament\Notifications\Notification::make()
                                ->title('Matrículas canceladas')
                                ->body('As matrículas selecionadas foram canceladas.')
                                ->success()
                                ->send();
                        }),
                ]),
            ])
            ->defaultSort('created_at', 'desc')
            ->striped()
            ->persistFiltersInSession()
            ->persistSearchInSession()
            ->paginated([10, 25, 50, 100]);
    }
}