<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\View as SchemaView;
use Filament\Forms\Components\Select;
use Filament\Notifications\Notification;
use BackedEnum;

class BoletinsPage extends Page
{
    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationLabel = 'Boletins e Relatórios';
    protected static ?string $title = 'Boletins e Relatórios Académicos';
    protected static ?int $navigationSort = 4;

    protected string $view = 'filament.pages.boletins';

    public ?array $data = [];

    public static function getNavigationGroup(): ?string
    {
        return 'Gestão Académica';
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                // RELATÓRIO POR TURMA
                Section::make('Relatório por Turma')
                    ->schema([
                        Select::make('turma_id')
                            ->label('Turma')
                            ->searchable()
                            ->options(
                                \App\Models\Turma::where('estado', 'ativa')
                                    ->limit(50)
                                    ->get()
                                    ->mapWithKeys(fn ($t) => [
                                        $t->id => "{$t->nome} ({$t->turno})"
                                    ])
                            ),
                    ])
                    ->footer(fn () => view('filament.components.btn-gerar-relatorio')),

                // BOLETIM INDIVIDUAL
                Section::make('Boletim Individual')
                    ->schema([
                        Select::make('aluno_id')
                            ->label('Aluno')
                            ->searchable()
                            ->options(
                                \App\Models\Aluno::where('situacao', 'activo')
                                    ->limit(50)
                                    ->get()
                                    ->mapWithKeys(fn ($a) => [
                                        $a->id => "{$a->processo} - {$a->nome_completo}"
                                    ])
                            ),
                    ])
                    ->footer(fn () => view('filament.components.btn-gerar-boletim')),
            ])
            ->statePath('data');
    }

    public function gerarBoletim(): void
    {
        $data = $this->data;
        if (!empty($data['aluno_id'])) {
            $this->redirect(url("/aluno/boletim/pdf?id={$data['aluno_id']}"));
            return;
        }
        Notification::make()->title('Selecione um aluno')->warning()->send();
    }

    public function gerarRelatorio(): void
    {
        $data = $this->data;
        if (!empty($data['turma_id'])) {
            $this->redirect(url("/professor/turma/alunos/{$data['turma_id']}"));
            return;
        }
        Notification::make()->title('Selecione uma turma')->warning()->send();
    }
}