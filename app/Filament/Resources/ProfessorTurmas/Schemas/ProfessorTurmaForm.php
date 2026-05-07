<?php

namespace App\Filament\Resources\ProfessorTurmas\Schemas;

use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use App\Models\Turma;
use App\Models\AnoLectivo;

class ProfessorTurmaForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Section::make('Atribuição de Professor à Turma')
                    ->schema([
                        Select::make('professor_id')
                            ->label('Professor')
                            ->relationship('professor', 'nome_completo')
                            ->searchable()
                            ->preload()
                            ->required()
                            ->helperText('Selecione o professor que irá lecionar')
                            ->columnSpan(1),

                        Select::make('turma_id')
                            ->label('Turma')
                            ->relationship('turma', 'nome')
                            ->searchable()
                            ->preload()
                            ->required()
                            ->reactive()
                            ->afterStateUpdated(fn ($state, callable $set) => $set('disciplina_id', null))
                            ->helperText('Selecione a turma')
                            ->columnSpan(1),

                        Select::make('disciplina_id')
                            ->label('Disciplina')
                            ->options(function (callable $get) {
                                $turmaId = $get('turma_id');
                                if (!$turmaId) {
                                    return [];
                                }
                                
                                $turma = Turma::find($turmaId);
                                if (!$turma) {
                                    return [];
                                }
                                
                                return $turma->disciplinas()
                                    ->pluck('disciplinas.nome', 'disciplinas.id')
                                    ->toArray();
                            })
                            ->searchable()
                            ->preload()
                            ->required()
                            ->helperText('Selecione a disciplina que o professor irá lecionar')
                            ->columnSpan(1),

                        Select::make('ano_lectivo_id')
                            ->label('Ano Lectivo')
                            ->options(fn() => AnoLectivo::pluck('ano', 'id'))
                            ->default(fn() => AnoLectivo::where('activo', true)->first()?->id)
                            ->required()
                            ->columnSpan(1),

                        TextInput::make('carga_horaria')
                            ->label('Carga Horária (h/semana)')
                            ->numeric()
                            ->minValue(1)
                            ->maxValue(20)
                            ->default(4)
                            ->required()
                            ->columnSpan(1),

                        Toggle::make('ativo')
                            ->label('Ativo')
                            ->default(true)
                            ->helperText('Desative para remover a atribuição temporariamente')
                            ->columnSpan(1),
                    ])
                    ->columns(2),
            ]);
    }
}