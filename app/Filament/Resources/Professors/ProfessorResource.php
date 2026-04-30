<?php

namespace App\Filament\Resources\Professors;

use App\Models\Professor;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use BackedEnum;
use App\Filament\Resources\Professors\Pages\ListProfessors;
use App\Filament\Resources\Professors\Pages\CreateProfessor;
use App\Filament\Resources\Professors\Pages\EditProfessor;
use App\Filament\Resources\Professors\Schemas\ProfessorForm;
use App\Filament\Resources\Professors\Tables\ProfessorsTable;

class ProfessorResource extends Resource
{
    protected static ?string $model = Professor::class;

    // ==================== NAVEGAÇÃO ====================
    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-academic-cap';
    protected static ?string $navigationLabel = 'Professores';
    protected static ?string $recordTitleAttribute = 'nome_completo';
    protected static ?int $navigationSort = 1;

    public static function getNavigationGroup(): ?string
    {
        return 'Gestão de Professores';
    }

    // ==================== FORMULÁRIO ====================
    public static function form(Schema $schema): Schema
    {
        return ProfessorForm::configure($schema);
    }

    // ==================== TABELA ====================
    public static function table(Table $table): Table
    {
        return ProfessorsTable::configure($table);
    }

    // ==================== PÁGINAS ====================
    public static function getPages(): array
    {
        return [
            'index' => ListProfessors::route('/'),
            'create' => CreateProfessor::route('/create'),
            'edit' => EditProfessor::route('/{record}/edit'),
        ];
    }

    // ==================== RELAÇÕES ====================
    public static function getRelations(): array
    {
        return [];
    }
}