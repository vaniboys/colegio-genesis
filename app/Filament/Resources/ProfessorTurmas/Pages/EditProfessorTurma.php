<?php

namespace App\Filament\Resources\ProfessorTurmas\Pages;

use App\Filament\Resources\ProfessorTurmas\ProfessorTurmaResource;
use Filament\Resources\Pages\EditRecord;
use Filament\Actions;

class EditProfessorTurma extends EditRecord
{
    protected static string $resource = ProfessorTurmaResource::class;
    
    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}