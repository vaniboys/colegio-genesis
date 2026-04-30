<?php

namespace App\Filament\Resources\Alunos;

use App\Filament\Resources\Alunos\Pages\CreateAluno;
use App\Filament\Resources\Alunos\Pages\EditAluno;
use App\Filament\Resources\Alunos\Pages\ListAlunos;
use App\Filament\Resources\Alunos\Schemas\AlunoForm;
use App\Filament\Resources\Alunos\Tables\AlunosTable;
use App\Models\Aluno;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AlunoResource extends Resource
{
    protected static ?string $model = Aluno::class;

    // Navegação
    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-user-group';
    protected static ?string $navigationLabel = 'Alunos';
    protected static ?int $navigationSort = 1;
    protected static ?string $recordTitleAttribute = 'nome_completo';

    public static function getNavigationGroup(): ?string
    {
        return 'Gestão de Alunos';
    }

    // Formulário
    public static function form(Schema $schema): Schema
    {
        return AlunoForm::configure($schema);
    }

    // Tabela
    public static function table(Table $table): Table
    {
        return AlunosTable::configure($table);
    }

    // Relações
    public static function getRelations(): array
    {
        return [];
    }

    // Páginas
    public static function getPages(): array
    {
        return [
            'index' => ListAlunos::route('/'),
            'create' => CreateAluno::route('/create'),
            'edit' => EditAluno::route('/{record}/edit'),
        ];
    }

    // Soft Deletes
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }

    // Permissões
    public static function canDelete($record): bool
    {
        return auth()->user()->role === 'admin';
    }

    public static function canForceDelete($record): bool
    {
        return auth()->user()->role === 'admin';
    }

    public static function canDeleteAny(): bool
    {
        return auth()->user()->role === 'admin';
    }
}