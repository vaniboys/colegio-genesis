<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Notifications\Notification;
use BackedEnum;
use App\Models\Turma;
use App\Models\Disciplina;
use App\Models\Professor;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Repeater;

class DisciplinasPorTurma extends Page
{
    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-book-open';
    protected static ?string $navigationLabel = 'Disciplinas por Turma';
    protected static ?string $title = 'Disciplinas por Turma';
    protected static ?int $navigationSort = 5;

    protected string $view = 'filament.pages.disciplinas-por-turma';

    public ?array $data = [];
    public ?string $selectedTurma = null;

    public static function getNavigationGroup(): ?string
    {
        return 'Gestão Académica';
    }

    public function mount(): void
    {
        $this->form->fill();
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Selecionar Turma')
                    ->schema([
                        Select::make('selectedTurma')
                            ->label('Turma')
                            ->searchable()
                            ->live()
                            ->afterStateUpdated(function ($state) {
                                $this->selectedTurma = $state;
                                $this->carregarDisciplinas();
                            })
                            ->options(
                                Turma::where('estado', 'ativa')
                                    ->with('classe')
                                    ->get()
                                    ->mapWithKeys(fn ($t) => [
                                        $t->id => "{$t->nome} - {$t->classe?->nome} ({$t->turno})"
                                    ])
                            ),
                    ]),

                Section::make('Disciplinas da Turma')
                    ->schema([
                        Repeater::make('disciplinas')
                            ->label('')
                            ->schema([
                                Select::make('disciplina_id')
                                    ->label('Disciplina')
                                    ->options(Disciplina::all()->pluck('nome', 'id'))
                                    ->required()
                                    ->searchable()
                                    ->columnSpan(2),
                                TextInput::make('carga_horaria_semanal')
                                    ->label('Carga Horária')
                                    ->numeric()
                                    ->default(4)
                                    ->minValue(1)
                                    ->maxValue(10)
                                    ->columnSpan(1),
                                Toggle::make('obrigatoria')
                                    ->label('Obrigatória')
                                    ->default(true)
                                    ->columnSpan(1),
                                Select::make('professor_id')
                                    ->label('Professor')
                                    ->options(Professor::pluck('nome_completo', 'id'))
                                    ->searchable()
                                    ->preload()
                                    ->nullable()
                                    ->columnSpan(2),
                            ])
                            ->columns(6)
                            ->defaultItems(0)
                            ->reorderable(false)
                            ->createItemButtonLabel('Adicionar Disciplina'),
                    ])
                    ->collapsible(),
            ])
            ->statePath('data');
    }

    public function carregarDisciplinas(): void
    {
        if ($this->selectedTurma) {
            $turma = Turma::with('disciplinas')->find($this->selectedTurma);
            $disciplinas = [];
            foreach ($turma->disciplinas as $disc) {
                $disciplinas[] = [
                    'disciplina_id' => $disc->id,
                    'carga_horaria_semanal' => $disc->pivot->carga_horaria_semanal ?? 4,
                    'obrigatoria' => $disc->pivot->obrigatoria ?? true,
                    'professor_id' => $disc->pivot->professor_id ?? null,
                ];
            }
            $this->data['disciplinas'] = $disciplinas;
            $this->form->fill($this->data);
        }
    }

    public function salvarDisciplinas(): void
    {
        $data = $this->form->getState();

        if ($this->selectedTurma && isset($data['disciplinas'])) {
            $turma = Turma::find($this->selectedTurma);
            
            $disciplinasData = [];
            foreach ($data['disciplinas'] as $disc) {
                if (isset($disc['disciplina_id'])) {
                    $disciplinasData[$disc['disciplina_id']] = [
                        'carga_horaria_semanal' => $disc['carga_horaria_semanal'] ?? 4,
                        'obrigatoria' => $disc['obrigatoria'] ?? true,
                        'professor_id' => $disc['professor_id'] ?? null,
                    ];
                }
            }
            
            $turma->disciplinas()->sync($disciplinasData);
            
            Notification::make()
                ->title('Disciplinas atualizadas com sucesso!')
                ->success()
                ->send();
                
            $this->carregarDisciplinas();
        }
    }
}