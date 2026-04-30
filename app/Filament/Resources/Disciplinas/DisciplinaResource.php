<?php

namespace App\Filament\Resources\Disciplinas;

use App\Filament\Resources\Disciplinas\Pages;
use App\Filament\Resources\Disciplinas\Schemas\DisciplinaForm;
use App\Filament\Resources\Disciplinas\Tables\DisciplinasTable;
use App\Models\Disciplina;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use BackedEnum;

class DisciplinaResource extends Resource
{
    protected static ?string $model = Disciplina::class;
    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-book-open';
    protected static ?string $navigationLabel = 'Disciplinas';
    protected static ?int $navigationSort = 1;

    public static function getNavigationGroup(): ?string
    {
        return 'Gestão Académica';
    }

    public static function form(Schema $schema): Schema
    {
        return DisciplinaForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return DisciplinasTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDisciplinas::route('/'),
            'create' => Pages\CreateDisciplina::route('/create'),
            'edit' => Pages\EditDisciplina::route('/{record}/edit'),
        ];
    }
}