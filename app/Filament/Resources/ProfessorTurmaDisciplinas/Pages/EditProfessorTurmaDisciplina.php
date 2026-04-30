<?php

namespace App\Filament\Resources\ProfessorTurmaDisciplinas\Pages;

use App\Filament\Resources\ProfessorTurmaDisciplinas\ProfessorTurmaDisciplinaResource;
use Filament\Resources\Pages\EditRecord;
use Filament\Actions\DeleteAction;

class EditProfessorTurmaDisciplina extends EditRecord
{
    protected static string $resource = ProfessorTurmaDisciplinaResource::class;

    protected function getHeaderActions(): array
    {
        return [DeleteAction::make()];
    }
}