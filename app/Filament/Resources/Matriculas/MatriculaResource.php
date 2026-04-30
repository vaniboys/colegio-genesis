<?php

namespace App\Filament\Resources\Matriculas;

use App\Models\Matricula;
use App\Filament\Resources\Matriculas\Pages;
use App\Filament\Resources\Matriculas\Schemas\MatriculaForm;
use App\Filament\Resources\Matriculas\Tables\MatriculasTable;
use App\Services\MatriculaService;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use BackedEnum;
use Illuminate\Database\Eloquent\Model;

class MatriculaResource extends Resource
{
    protected static ?string $model = Matricula::class;
    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-clipboard-document-check';
    protected static ?string $navigationLabel = 'Matrículas';
    protected static ?int $navigationSort = 2;
    protected static ?string $recordTitleAttribute = 'numero_matricula';

    public static function getNavigationGroup(): ?string
    {
        return 'Gestão de Alunos';
    }

    public static function form(Schema $schema): Schema
    {
        return MatriculaForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return MatriculasTable::configure($table);
    }

    public function handleRecordCreation(array $data): Model
    {
        return MatriculaService::matricular($data);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMatriculas::route('/'),
            'create' => Pages\CreateMatricula::route('/create'),
            'edit' => Pages\EditMatricula::route('/{record}/edit'),
        ];
    }

    public static function getRelations(): array
    {
        return [];
    }
}