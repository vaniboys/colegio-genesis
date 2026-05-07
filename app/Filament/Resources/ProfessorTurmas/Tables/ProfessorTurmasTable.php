<?php

namespace App\Filament\Resources\ProfessorTurmas\Tables;

use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\Action;

class ProfessorTurmasTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('professor.nome_completo')
                    ->label('Professor')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('turma.nome')
                    ->label('Turma')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('turma.classe.nome')
                    ->label('Classe')
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('disciplina.nome')
                    ->label('Disciplina')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('anoLectivo.ano')
                    ->label('Ano Lectivo')
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('carga_horaria')
                    ->label('Carga H.')
                    ->numeric()
                    ->sortable()
                    ->toggleable(),

                IconColumn::make('ativo')
                    ->label('Ativo')
                    ->boolean()
                    ->toggleable(),

                TextColumn::make('created_at')
                    ->label('Criado em')
                    ->dateTime('d/m/Y H:i')
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('ano_lectivo_id')
                    ->label('Ano Lectivo')
                    ->relationship('anoLectivo', 'ano')
                    ->default(fn() => \App\Models\AnoLectivo::where('activo', true)->first()?->id),

                SelectFilter::make('professor_id')
                    ->label('Professor')
                    ->relationship('professor', 'nome_completo')
                    ->searchable()
                    ->preload(),

                SelectFilter::make('turma_id')
                    ->label('Turma')
                    ->relationship('turma', 'nome')
                    ->searchable()
                    ->preload(),

                TernaryFilter::make('ativo')
                    ->label('Status')
                    ->placeholder('Todos')
                    ->trueLabel('Ativos')
                    ->falseLabel('Inativos'),
            ])
            
            ->defaultSort('created_at', 'desc')
            ->striped()
            ->persistFiltersInSession()
            ->persistSearchInSession()
            ->paginated([10, 25, 50, 100]);
    }
}