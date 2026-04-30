<?php

namespace App\Filament\Resources\Professors\Pages;

use App\Filament\Resources\Professors\ProfessorResource;
use Filament\Resources\Pages\ListRecords;
use Filament\Actions\CreateAction;

class ListProfessors extends ListRecords
{
    protected static string $resource = ProfessorResource::class;

    //  Adiciona o título em português
    protected ?string $heading = 'Lista de todos os professores';
   
    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()->label('Novo Professor'),
        ];
    }
}