<?php

namespace App\Filament\Resources\Audits;

use OwenIt\Auditing\Models\Audit;
use App\Filament\Resources\Audits\Pages;
use App\Filament\Resources\Audits\Tables\AuditsTable;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use BackedEnum;

class AuditResource extends Resource
{
    protected static ?string $model = Audit::class;
    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-clipboard-document-list';
    protected static ?string $navigationLabel = 'Registo de Atividades';
    protected static ?int $navigationSort = 3;

    public static function getNavigationGroup(): ?string
    {
        return 'Gestão de utilizadores';
    }

    public static function table(Table $table): Table
    {
        return AuditsTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAudits::route('/'),
        ];
    }
}