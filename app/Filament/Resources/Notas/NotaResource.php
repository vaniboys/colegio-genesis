<?php

namespace App\Filament\Resources\Notas;

use App\Filament\Resources\Notas\Pages;
use App\Filament\Resources\Notas\Schemas\NotaForm;
use App\Filament\Resources\Notas\Tables\NotasTable;
use App\Models\Nota;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;

class NotaResource extends Resource
{
    protected static ?string $model = Nota::class;

    // ==================== NAVEGAÇÃO ====================
    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-pencil-square';
    protected static ?string $navigationLabel = 'Notas';
    protected static ?int $navigationSort = 2;

    public static function getNavigationGroup(): ?string
    {
        return 'Gestão Académica';
    }

    // ==================== FORMULÁRIO ====================
    public static function form(Schema $schema): Schema
    {
        return NotaForm::configure($schema);
    }

    // ==================== TABELA ====================
    public static function table(Table $table): Table
    {
        return NotasTable::configure($table);
    }

    // ==================== PÁGINAS ====================
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListNotas::route('/'),
            'create' => Pages\CreateNota::route('/create'),
            'edit' => Pages\EditNota::route('/{record}/edit'),
        ];
    }
}