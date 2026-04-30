<?php

namespace App\Filament\Resources\ProfessorTurmaDisciplinas;

use App\Filament\Resources\ProfessorTurmaDisciplinas\Pages;
use App\Filament\Resources\ProfessorTurmaDisciplinas\Schemas\ProfessorTurmaDisciplinaForm;
use App\Filament\Resources\ProfessorTurmaDisciplinas\Tables\ProfessorTurmaDisciplinasTable;
use App\Models\ProfessorTurmaDisciplina;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use BackedEnum;

class ProfessorTurmaDisciplinaResource extends Resource
{
    protected static ?string $model = ProfessorTurmaDisciplina::class;
    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-user-group';
    protected static ?string $navigationLabel = 'Prof. por Turma';
    protected static ?int $navigationSort = 2;

    public static function getNavigationGroup(): ?string
    {
        return 'Gestão de Professores';
    }

    public static function form(Schema $schema): Schema
    {
        return ProfessorTurmaDisciplinaForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ProfessorTurmaDisciplinasTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProfessorTurmaDisciplinas::route('/'),
            'create' => Pages\CreateProfessorTurmaDisciplina::route('/create'),
            'edit' => Pages\EditProfessorTurmaDisciplina::route('/{record}/edit'),
        ];
    }
}