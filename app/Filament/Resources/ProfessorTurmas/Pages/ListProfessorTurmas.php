<?php

namespace App\Filament\Resources\ProfessorTurmas\Pages;

use App\Filament\Resources\ProfessorTurmas\ProfessorTurmaResource;
use Filament\Resources\Pages\ListRecords;
use Filament\Actions;

class ListProfessorTurmas extends ListRecords
{
    protected static string $resource = ProfessorTurmaResource::class;
    
    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Nova Atribuição')
                ->icon('heroicon-m-plus'),
        ];
    }
}