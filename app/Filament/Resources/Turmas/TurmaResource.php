<?php

namespace App\Filament\Resources\Turmas;

use App\Filament\Resources\Turmas\Pages\CreateTurma;
use App\Filament\Resources\Turmas\Pages\EditTurma;
use App\Filament\Resources\Turmas\Pages\ListTurmas;
use App\Filament\Resources\Turmas\Schemas\TurmaForm;
use App\Filament\Resources\Turmas\Tables\TurmasTable;
use App\Models\Turma;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;

class TurmaResource extends Resource
{
    protected static ?string $model = Turma::class;

    // ==================== NAVEGAÇÃO ====================
    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-building-library';
    protected static ?string $navigationLabel = 'Turmas';
    protected static ?int $navigationSort = 1;
    protected static ?string $recordTitleAttribute = 'nome';

    public static function getNavigationGroup(): ?string
    {
        return 'Gestão de Turmas';
    }

    // ==================== FORMULÁRIO ====================
    public static function form(Schema $schema): Schema
    {
        return TurmaForm::configure($schema);
    }

    // ==================== TABELA ====================
    public static function table(Table $table): Table
    {
        return TurmasTable::configure($table);
    }

    // ==================== PÁGINAS ====================
    public static function getPages(): array
    {
        return [
            'index' => ListTurmas::route('/'),
            'create' => CreateTurma::route('/create'),
            'edit' => EditTurma::route('/{record}/edit'),
        ];
    }

    // ==================== RELAÇÕES ====================
    public static function getRelations(): array
    {
        return [];
    }

    // ==================== PERMISSÕES ====================
    public static function canDelete($record): bool
    {
        return auth()->user()->role === 'admin';
    }

    public static function canDeleteAny(): bool
    {
        return auth()->user()->role === 'admin';
    }
}