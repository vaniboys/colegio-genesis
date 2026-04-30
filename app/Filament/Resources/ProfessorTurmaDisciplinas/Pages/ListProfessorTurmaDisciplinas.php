<?php

namespace App\Filament\Resources\ProfessorTurmaDisciplinas\Pages;

use App\Filament\Resources\ProfessorTurmaDisciplinas\ProfessorTurmaDisciplinaResource;
use Filament\Resources\Pages\ListRecords;
use Filament\Actions\CreateAction;

class ListProfessorTurmaDisciplinas extends ListRecords
{
    protected static string $resource = ProfessorTurmaDisciplinaResource::class;

    protected function getHeaderActions(): array
    {
        return [CreateAction::make()->label('Atribuir Professor')];
    }
}