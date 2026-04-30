<?php

namespace App\Filament\Resources\Matriculas\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Placeholder;

class MatriculaForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->schema([
                // Nº Matrícula (automático no Observer)
                TextInput::make('numero_matricula')
                    ->label('Nº Matrícula')
                    ->disabled()
                    ->dehydrated()
                    ->hidden(fn ($context) => $context === 'create')
                    ->required(),

                // ✅ ALUNO - Relationship + getSearchResultsUsing (híbrido)
                Select::make('aluno_id')
                    ->label('Aluno')
                    ->relationship('aluno', 'nome_completo')
                    ->searchable()
                    ->preload(false)
                    ->required()
                    ->getSearchResultsUsing(fn (string $search) =>
                        \App\Models\Aluno::where('nome_completo', 'like', "%{$search}%")
                            ->orWhere('processo', 'like', "%{$search}%")
                            ->orWhere('bi', 'like', "%{$search}%")
                            ->limit(20)
                            ->get()
                            ->mapWithKeys(fn ($aluno) => [
                                $aluno->id => "{$aluno->processo} - {$aluno->nome_completo}"
                            ])
                    )
                    ->getOptionLabelUsing(function ($value) {
                        static $cache = [];
                        if (!$value) return '—';
                        $cache[$value] ??= \App\Models\Aluno::whereKey($value)->value('nome_completo');
                        return $cache[$value] ?? '—';
                    }),

                // ✅ TURMA - Relationship + getSearchResultsUsing (híbrido)
                Select::make('turma_id')
                    ->label('Turma')
                    ->relationship('turma', 'nome')
                    ->searchable()
                    ->preload(false)
                    ->required()
                    ->getSearchResultsUsing(fn (string $search) =>
                        \App\Models\Turma::where('estado', 'ativa')
                            ->where('nome', 'like', "%{$search}%")
                            ->limit(20)
                            ->get()
                            ->mapWithKeys(fn ($turma) => [
                                $turma->id => "{$turma->nome} (" . max(0, $turma->capacidade_maxima - $turma->vagas_ocupadas) . " vagas)"
                            ])
                    )
                    ->getOptionLabelUsing(function ($value) {
                        static $cache = [];
                        if (!$value) return '—';
                        $cache[$value] ??= \App\Models\Turma::whereKey($value)->value('nome');
                        return $cache[$value] ?? '—';
                    }),

                // Info da turma
                Placeholder::make('info_turma')
                    ->label('Informação da Turma')
                    ->content(function ($get) {
                        $id = $get('turma_id');
                        if (!$id) return '—';
                        static $cache = [];
                        $cache[$id] ??= \App\Models\Turma::select('nome', 'turno', 'capacidade_maxima', 'vagas_ocupadas')->find($id);
                        $turma = $cache[$id];
                        if (!$turma) return '—';
                        $livres = max(0, $turma->capacidade_maxima - $turma->vagas_ocupadas);
                        $lotacao = $livres === 0 ? '🔴' : ($livres < 5 ? '🟡' : '🟢');
                        return "{$lotacao} {$turma->nome} | Vagas: {$livres} | Turno: {$turma->turno}";
                    }),

                Select::make('ano_lectivo_id')
                    ->label('Ano Lectivo')
                    ->relationship('anoLectivo', 'ano')
                    ->required(),

                Select::make('situacao')
                    ->label('Situação')
                    ->options([
                        'ativa' => '🟢 Ativa',
                        'pendente' => '🟡 Pendente',
                        'cancelada' => '🔴 Cancelada',
                        'concluida' => '⚫ Concluída',
                    ])
                    ->default('ativa')
                    ->required(),
            ]);
    }
}