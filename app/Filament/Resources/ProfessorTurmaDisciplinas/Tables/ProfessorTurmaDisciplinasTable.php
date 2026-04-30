<?php

namespace App\Filament\Resources\ProfessorTurmaDisciplinas\Tables;

use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;

class ProfessorTurmaDisciplinasTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('professor.nome_completo')->label('Professor')->searchable(),
                TextColumn::make('turma.nome')->label('Turma')->searchable(),
                TextColumn::make('disciplina.nome')->label('Disciplina')->searchable(),
                TextColumn::make('anoLectivo.ano')->label('Ano'),
                TextColumn::make('carga_horaria')->label('Carga H.'),
                IconColumn::make('ativo')->label('Ativo')->boolean(),
                TextColumn::make('created_at')->label('Criado em')->dateTime('d/m/Y')->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('turma_id')->relationship('turma', 'nome')->label('Turma'),
                SelectFilter::make('professor_id')->relationship('professor', 'nome_completo')->label('Professor'),
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                DeleteBulkAction::make(),
            ])
            ->defaultSort('turma_id', 'asc');
    }
}