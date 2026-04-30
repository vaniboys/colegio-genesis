<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use BackedEnum;

class Privacy extends Page
{
    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-shield-check';
    protected static ?string $navigationLabel = 'Privacidade de Dados';
    protected static ?int $navigationSort = 4;

    // SEM static
    protected string $view = 'filament.pages.privacy';

    public static function getNavigationGroup(): ?string
    {
        return 'Gestão de utilizadores';
    }

    public function getTitle(): string
    {
        return 'Política de Privacidade';
    }
}