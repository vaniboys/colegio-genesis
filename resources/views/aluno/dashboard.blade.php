@extends('layouts.aluno')

@section('content')
<!-- Informações do Aluno e Turma -->
<div class="row g-3 mb-4">
    <div class="col-12">
        <div class="card bg-primary text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center flex-wrap">
                    <div>
                        <h5 class="mb-1"><i class="fas fa-user-graduate me-2"></i> {{ $aluno->nome_completo ?? auth()->user()->name }}</h5>
                        <p class="mb-0 opacity-75">
                            <i class="fas fa-id-card me-1"></i> Processo: {{ $aluno->processo ?? 'N/A' }} |
                            <i class="fas fa-calendar-alt ms-2 me-1"></i> Ano Lectivo: {{ $matricula?->anoLectivo?->ano ?? date('Y') }}
                        </p>
                    </div>
                    <div class="text-end">
                        <span class="badge bg-light text-primary fs-6">
                            <i class="fas fa-school me-1"></i> 
                            Turma: {{ $turma->nome ?? $matricula?->turma?->nome ?? 'Não atribuída' }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Cards de Estatísticas -->
<div class="row g-3 mb-4">
    <div class="col-md-3 col-sm-6">
        <div class="stats-card">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="stats-value">{{ number_format($mediaGeral ?? 0, 1) }}</div>
                    <div class="stats-label">Média Geral</div>
                    <small class="text-{{ ($mediaGeral ?? 0) >= 10 ? 'success' : 'danger' }}">
                        <i class="fas fa-{{ ($mediaGeral ?? 0) >= 10 ? 'arrow-up' : 'arrow-down' }}"></i>
                        {{ ($mediaGeral ?? 0) >= 10 ? 'Aprovado' : 'Recuperação' }}
                    </small>
                </div>
                <div class="stat-icon bg-primary-light">
                    <i class="fas fa-chart-line"></i>
                </div>
            </div>
            <div class="progress mt-3" style="height: 5px;">
                <div class="progress-bar bg-{{ ($mediaGeral ?? 0) >= 10 ? 'success' : 'danger' }}" 
                     style="width: {{ min(($mediaGeral ?? 0) * 5, 100) }}%"></div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 col-sm-6">
        <div class="stats-card">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="stats-value">{{ $totalFaltas ?? 0 }}</div>
                    <div class="stats-label">Total de Faltas</div>
                    <small class="text-{{ ($totalFaltas ?? 0) > 10 ? 'danger' : 'warning' }}">
                        <i class="fas fa-calendar-times"></i> 
                        {{ ($totalFaltas ?? 0) > 10 ? 'Acima do limite' : 'Dentro do limite' }}
                    </small>
                </div>
                <div class="stat-icon bg-warning-light">
                    <i class="fas fa-calendar-alt"></i>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 col-sm-6">
        <div class="stats-card">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="stats-value">{{ $tarefasPendentes ?? 0 }}</div>
                    <div class="stats-label">Tarefas Pendentes</div>
                    <small class="text-warning">
                        <i class="fas fa-clock"></i> Aguardando entrega
                    </small>
                </div>
                <div class="stat-icon bg-warning-light">
                    <i class="fas fa-tasks"></i>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 col-sm-6">
        <div class="stats-card">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="stats-value">{{ $comunicadosNaoLidos ?? 0 }}</div>
                    <div class="stats-label">Comunicados</div>
                    <small class="text-info">
                        <i class="fas fa-envelope"></i> Novos avisos
                    </small>
                </div>
                <div class="stat-icon bg-info-light">
                    <i class="fas fa-bullhorn"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Gráfico de Desempenho e Últimas Notas -->
<div class="row g-3 mb-4">
    <div class="col-md-7">
        <div class="card h-100">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="fas fa-chart-line me-2 text-primary"></i> Desempenho por Disciplina</span>
                <span class="badge bg-primary">{{ $ultimasNotas->count() }} Disciplinas</span>
            </div>
            <div class="card-body">
                @if($ultimasNotas->count() > 0)
                    <canvas id="desempenhoChart" height="250"></canvas>
                @else
                    <div class="text-center py-5 text-muted">
                        <i class="fas fa-chart-line fa-3x mb-2"></i>
                        <p>Nenhuma nota registrada ainda</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
    
    <div class="col-md-5">
        <div class="card h-100">
            <div class="card-header">
                <i class="fas fa-star me-2 text-warning"></i> Melhores Desempenhos
            </div>
            <div class="card-body p-0">
                <div class="list-group list-group-flush">
                    @forelse($ultimasNotas->sortByDesc('media_trimestral')->take(3) as $nota)
                    <div class="list-group-item">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <strong>{{ $nota->disciplina->nome ?? 'Disciplina' }}</strong>
                                <div class="small text-muted">Média do trimestre</div>
                            </div>
                            <div class="text-end">
                                <span class="badge bg-success fs-6">{{ number_format($nota->media_trimestral ?? 0, 1) }}</span>
                                <div class="small text-success">
                                    <i class="fas fa-trophy"></i> Destaque
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-4 text-muted">Nenhuma nota registrada</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Últimos Comunicados e Próximas Tarefas -->
<div class="row g-3">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <i class="fas fa-bullhorn me-2 text-danger"></i> Últimos Comunicados
            </div>
            <div class="card-body p-0">
                @forelse($ultimosComunicados ?? [] as $comunicado)
                <div class="comunicado-item">
                    <div class="d-flex justify-content-between">
                        <strong>{{ $comunicado->titulo }}</strong>
                        <small class="text-muted">{{ $comunicado->created_at->diffForHumans() }}</small>
                    </div>
                    <p class="small mb-0 mt-1">{{ Str::limit($comunicado->mensagem, 100) }}</p>
                </div>
                @empty
                <div class="text-center py-4 text-muted">Nenhum comunicado recente</div>
                @endforelse
                <div class="text-center p-2 border-top">
                    <a href="{{ route('aluno.comunicados') }}" class="btn btn-sm btn-link">Ver todos os comunicados</a>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <i class="fas fa-tasks me-2 text-success"></i> Próximas Tarefas
            </div>
            <div class="card-body p-0">
                @forelse($proximasTarefas ?? [] as $tarefa)
                <div class="comunicado-item">
                    <div class="d-flex justify-content-between">
                        <strong>{{ $tarefa->titulo }}</strong>
                        <span class="badge bg-warning">{{ date('d/m', strtotime($tarefa->data_entrega)) }}</span>
                    </div>
                    <p class="small mb-0 mt-1">{{ Str::limit($tarefa->descricao, 80) }}</p>
                    <div class="mt-2">
                        <a href="{{ route('aluno.tarefas') }}" class="btn btn-sm btn-outline-primary">Ver detalhes</a>
                    </div>
                </div>
                @empty
                <div class="text-center py-4 text-muted">Nenhuma tarefa pendente</div>
                @endforelse
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    @if($ultimasNotas->count() > 0)
    const ctx = document.getElementById('desempenhoChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($ultimasNotas->pluck('disciplina.nome')) !!},
            datasets: [{
                label: 'Média das Notas',
                data: {!! json_encode($ultimasNotas->pluck('media_trimestral')->map(function($n) { return number_format($n, 1); })) !!},
                backgroundColor: '#1e3a8a',
                borderRadius: 8,
                barPercentage: 0.6
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            scales: {
                y: {
                    beginAtZero: true,
                    max: 20,
                    title: { display: true, text: 'Notas (0-20)' }
                }
            },
            plugins: {
                legend: { position: 'top' },
                tooltip: { callbacks: { label: function(context) { return context.raw + ' valores'; } } }
            }
        }
    });
    @endif
</script>
@endpush
@endsection