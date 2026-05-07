<?php

namespace App\Filament\Resources\ProfessorTurmas;

use App\Filament\Resources\ProfessorTurmas\Pages\CreateProfessorTurma;
use App\Filament\Resources\ProfessorTurmas\Pages\EditProfessorTurma;
use App\Filament\Resources\ProfessorTurmas\Pages\ListProfessorTurmas;
use App\Filament\Resources\ProfessorTurmas\Schemas\ProfessorTurmaForm;
use App\Filament\Resources\ProfessorTurmas\Tables\ProfessorTurmasTable;
use App\Models\ProfessorTurma;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;

class ProfessorTurmaResource extends Resource
{
    protected static ?string $model = ProfessorTurma::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-user-group';
    protected static ?string $navigationLabel = 'Atribuição de Turmas';
    protected static ?int $navigationSort = 5;

    public static function getNavigationGroup(): ?string
    {
        return 'Gestão Académica';
    }

    public static function form(Schema $schema): Schema
    {
        return ProfessorTurmaForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ProfessorTurmasTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListProfessorTurmas::route('/'),
            'create' => CreateProfessorTurma::route('/create'),
            'edit' => EditProfessorTurma::route('/{record}/edit'),
        ];
    }
}