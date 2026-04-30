<?php

namespace App\Filament\Resources\Livros;

use App\Filament\Resources\Livros\Pages\CreateLivro;
use App\Filament\Resources\Livros\Pages\EditLivro;
use App\Filament\Resources\Livros\Pages\ListLivros;
use App\Filament\Resources\Livros\Schemas\LivroForm;
use App\Filament\Resources\Livros\Tables\LivrosTable;
use App\Models\Livro;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class LivroResource extends Resource
{
    protected static ?string $model = Livro::class;

    // ==================== NAVEGAÇÃO ====================
    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-book-open';
    protected static ?string $navigationLabel = 'Livros de Apoio';
    protected static ?int $navigationSort = 6;

    public static function getNavigationGroup(): ?string
    {
        return 'Gestão Académica';
    }

    public static function form(Schema $schema): Schema
    {
        return LivroForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return LivrosTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListLivros::route('/'),
            'create' => CreateLivro::route('/create'),
            'edit' => EditLivro::route('/{record}/edit'),
        ];
    }
}
