<?php

namespace App\Filament\Resources\Matriculas\Schemas;

use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Placeholder;
use App\Models\Aluno;
use App\Models\Turma;

class MatriculaForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Tabs::make('Registo de Matrícula')
                    ->tabs([
                        // ==================== ABA 1: INFORMAÇÕES PRINCIPAIS ====================
                        Tabs\Tab::make('Informações da Matrícula')
                            ->icon('heroicon-o-document-text')
                            ->schema([
                                Section::make('Dados da Matrícula')
                                    ->schema([
                                        TextInput::make('numero_matricula')
                                            ->label('Nº Matrícula')
                                            ->disabled()
                                            ->dehydrated()
                                            ->hidden(fn ($context) => $context === 'create')
                                            ->required()
                                            ->columnSpan(2),

                                        Select::make('ano_lectivo_id')
                                            ->label('Ano Lectivo')
                                            ->relationship('anoLectivo', 'ano')
                                            ->required()
                                            ->searchable()
                                            ->preload()
                                            ->columnSpan(1),

                                        Select::make('situacao')
                                            ->label('Situação')
                                            ->options([
                                                'ativa' => '🟢 Ativa',
                                                'pendente' => '🟡 Pendente',
                                                'cancelada' => '🔴 Cancelada',
                                                'concluida' => '⚫ Concluída',
                                            ])
                                            ->default('ativa')
                                            ->required()
                                            ->columnSpan(1),
                                    ])
                                    ->columns(2),
                            ]),

                        // ==================== ABA 2: DADOS DO ALUNO ====================
                        Tabs\Tab::make('Dados do Aluno')
                            ->icon('heroicon-o-user')
                            ->schema([
                                Section::make('Seleção do Aluno')
                                    ->schema([
                                            
                                             Select::make('aluno_id')
                                            ->label('Aluno')
                                            ->relationship('aluno', 'nome_completo')
                                            ->required()
                                            ->searchable()
                                            ->preload(false)
                                            
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
                                            })

                                            ->helperText('Pesquise pelo nome, processo ou BI do aluno')
                                            ->getSearchResultsUsing(fn (string $search) =>
                                                Aluno::where('nome_completo', 'like', "%{$search}%")
                                                    ->orWhere('processo', 'like', "%{$search}%")
                                                    ->orWhere('bi', 'like', "%{$search}%")
                                                    ->limit(20)
                                                    ->get()
                                                    ->mapWithKeys(fn ($aluno) => [
                                                        $aluno->id => "{$aluno->processo} - {$aluno->nome_completo}"
                                                    ])
                                            )
                                            
                                    ]),

                                Section::make('Informações do Aluno Selecionado')
                                    ->schema([
                                        Placeholder::make('info_aluno_processo')
                                            ->label('Processo')
                                            ->content(fn ($get) => self::getAlunoInfo($get('aluno_id'), 'processo'))
                                            ->columnSpan(1),

                                        Placeholder::make('info_aluno_nome')
                                            ->label('Nome Completo')
                                            ->content(fn ($get) => self::getAlunoInfo($get('aluno_id'), 'nome_completo'))
                                            ->columnSpan(1),

                                        Placeholder::make('info_aluno_bi')
                                            ->label('BI')
                                            ->content(fn ($get) => self::getAlunoInfo($get('aluno_id'), 'bi'))
                                            ->columnSpan(1),

                                        Placeholder::make('info_aluno_sexo')
                                            ->label('Sexo')
                                            ->content(fn ($get) => self::getAlunoInfo($get('aluno_id'), 'sexo_formatado'))
                                            ->columnSpan(1),

                                        Placeholder::make('info_aluno_telefone')
                                            ->label('Telefone')
                                            ->content(fn ($get) => self::getAlunoInfo($get('aluno_id'), 'telefone'))
                                            ->columnSpan(1),

                                        Placeholder::make('info_aluno_email')
                                            ->label('Email')
                                            ->content(fn ($get) => self::getAlunoInfo($get('aluno_id'), 'email'))
                                            ->columnSpan(1),
                                    ])
                                    ->columns(2)
                                    ->collapsible(),
                            ]),

                        // ==================== ABA 3: DADOS DA TURMA ====================
                        Tabs\Tab::make('Turma')
                            ->icon('heroicon-o-academic-cap')
                            ->schema([
                                Section::make('Seleção da Turma')
                                    ->schema([
                                        Select::make('turma_id')
                                            ->label('Turma')
                                            ->relationship('turma', 'nome')
                                            ->searchable()
                                            ->preload(false)
                                            ->required()
                                            ->helperText('Selecione a turma disponível para matrícula')
                                            ->getSearchResultsUsing(fn (string $search) =>
                                                Turma::where('estado', 'ativa')
                                                    ->where(function($query) use ($search) {
                                                        $query->where('nome', 'like', "%{$search}%")
                                                            ->orWhereHas('curso', function($q) use ($search) {
                                                                $q->where('nome', 'like', "%{$search}%");
                                                            })
                                                            ->orWhereHas('classe', function($q) use ($search) {
                                                                $q->where('nome', 'like', "%{$search}%");
                                                            });
                                                    })
                                                    ->with(['curso', 'classe'])
                                                    ->limit(20)
                                                    ->get()
                                                    ->mapWithKeys(fn ($turma) => [
                                                        $turma->id => self::formatTurmaLabel($turma)
                                                    ])
                                            )
                                            ->getOptionLabelUsing(function ($value) {
                                                static $cache = [];
                                                if (!$value) return '—';
                                                if (!isset($cache[$value])) {
                                                    $turma = Turma::with(['curso', 'classe'])->find($value);
                                                    $cache[$value] = $turma ? self::formatTurmaLabel($turma) : '—';
                                                }
                                                return $cache[$value];
                                            })
                                            ->columnSpanFull(),
                                    ]),

                                Section::make('Informações da Turma Selecionada')
                                    ->schema([
                                        Placeholder::make('info_turma_nome')
                                            ->label('Turma')
                                            ->content(fn ($get) => self::getTurmaInfo($get('turma_id'), 'nome'))
                                            ->columnSpan(1),

                                        Placeholder::make('info_turma_curso')
                                            ->label('Curso')
                                            ->content(fn ($get) => self::getTurmaInfo($get('turma_id'), 'curso.nome'))
                                            ->columnSpan(1),

                                        Placeholder::make('info_turma_classe')
                                            ->label('Classe')
                                            ->content(fn ($get) => self::getTurmaInfo($get('turma_id'), 'classe.nome'))
                                            ->columnSpan(1),

                                        Placeholder::make('info_turma_turno')
                                            ->label('Turno')
                                            ->content(fn ($get) => self::getTurmaInfo($get('turma_id'), 'turno'))
                                            ->columnSpan(1),

                                        Placeholder::make('info_turma_capacidade')
                                            ->label('Capacidade Máxima')
                                            ->content(fn ($get) => self::getTurmaInfo($get('turma_id'), 'capacidade_maxima'))
                                            ->columnSpan(1),

                                        Placeholder::make('info_turma_vagas_ocupadas')
                                            ->label('Vagas Ocupadas')
                                            ->content(fn ($get) => self::getTurmaInfo($get('turma_id'), 'vagas_ocupadas'))
                                            ->columnSpan(1),

                                        Placeholder::make('info_turma_status')
                                            ->label('Status da Turma')
                                            ->content(function ($get) {
                                                $id = $get('turma_id');
                                                if (!$id) return '—';
                                                
                                                static $cache = [];
                                                if (!isset($cache[$id])) {
                                                    $cache[$id] = Turma::select('capacidade_maxima', 'vagas_ocupadas', 'estado')->find($id);
                                                }
                                                
                                                $turma = $cache[$id];
                                                if (!$turma) return '—';
                                                
                                                $livres = max(0, $turma->capacidade_maxima - $turma->vagas_ocupadas);
                                                $status = $livres === 0 ? '🔴 Turma Lotada' : ($livres < 5 ? '🟡 Poucas Vagas' : '🟢 Vagas Disponíveis');
                                                
                                                if ($turma->estado !== 'ativa') {
                                                    $status .= ' ⚠️ Turma Inativa';
                                                }
                                                
                                                return $status;
                                            })
                                            ->columnSpan(2),
                                    ])
                                    ->columns(2)
                                    ->collapsible(),
                            ]),
                    ])
                    ->persistTab()
                    ->columnSpanFull(),
            ])
            ->columns(1);
    }

    // ==================== MÉTODOS AUXILIARES ====================
    
    /**
     * Formata o label da turma para exibição
     */
    private static function formatTurmaLabel($turma): string
    {
        $nome = $turma->nome ?? 'Turma';
        $curso = $turma->curso?->nome ?? 'Curso não definido';
        $classe = $turma->classe?->nome ?? 'Classe não definida';
        $vagas = max(0, ($turma->capacidade_maxima ?? 0) - ($turma->vagas_ocupadas ?? 0));
        
        return "{$nome} - {$classe} - {$curso} ({$vagas} vagas)";
    }
    
    /**
     * Obtém informações do aluno via cache
     */
    private static function getAlunoInfo($alunoId, $field)
    {
        if (!$alunoId) return '—';
        
        static $cache = [];
        
        if (!isset($cache[$alunoId])) {
            $cache[$alunoId] = Aluno::select(['id', 'processo', 'nome_completo', 'bi', 'sexo', 'telefone', 'email'])
                ->find($alunoId);
        }
        
        $aluno = $cache[$alunoId];
        if (!$aluno) return '—';
        
        return match($field) {
            'processo' => $aluno->processo ?? '—',
            'nome_completo' => $aluno->nome_completo ?? '—',
            'bi' => $aluno->bi ?? '—',
            'sexo_formatado' => $aluno->sexo === 'M' ? 'Masculino' : ($aluno->sexo === 'F' ? 'Feminino' : '—'),
            'telefone' => $aluno->telefone ?? '—',
            'email' => $aluno->email ?? 'Não informado',
            default => '—',
        };
    }
    
    /**
     * Obtém informações da turma via cache
     */
    private static function getTurmaInfo($turmaId, $field)
    {
        if (!$turmaId) return '—';
        
        static $cache = [];
        
        if (!isset($cache[$turmaId])) {
            $cache[$turmaId] = Turma::with(['curso', 'classe'])->find($turmaId);
        }
        
        $turma = $cache[$turmaId];
        if (!$turma) return '—';
        
        // Usando null coalescing para evitar erro "property on null"
        return match($field) {
            'nome' => $turma->nome ?? '—',
            'curso.nome' => $turma->curso?->nome ?? 'Curso não definido',
            'classe.nome' => $turma->classe?->nome ?? 'Classe não definida',
            'turno' => $turma->turno ?? '—',
            'capacidade_maxima' => $turma->capacidade_maxima ?? '—',
            'vagas_ocupadas' => $turma->vagas_ocupadas ?? '—',
            default => '—',
        };
    }
}