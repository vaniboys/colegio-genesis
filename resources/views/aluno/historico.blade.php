@extends('layouts.aluno')

@section('content')
<div class="container-fluid px-4">
    {{-- Cabeçalho --}}
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
        <div>
            <h4 class="mb-1" style="color: #1e3a8a;">
                <i class="fas fa-history me-2"></i> Histórico Escolar
            </h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('aluno.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Histórico Escolar</li>
                </ol>
            </nav>
        </div>
        <div>
            <span class="badge bg-primary p-2">
                <i class="fas fa-user-graduate me-1"></i> Aluno: {{ $aluno->nome_completo }}
            </span>
        </div>
    </div>

    {{-- Resumo do Aluno --}}
    <div class="row g-3 mb-4">
        <div class="col-md-3 col-sm-6">
            <div class="card summary-card border-top-primary">
                <div class="card-body py-3">
                    <div class="row align-items-center">
                        <div class="col-4">
                            <i class="fas fa-calendar-alt fa-2x text-primary"></i>
                        </div>
                        <div class="col-8 text-end">
                            <h3 class="mb-0 fw-bold text-primary">{{ count($historico) }}</h3>
                            <small class="text-muted">ANOS LECTIVOS</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="card summary-card border-top-success">
                <div class="card-body py-3">
                    <div class="row align-items-center">
                        <div class="col-4">
                            <i class="fas fa-check-circle fa-2x text-success"></i>
                        </div>
                        <div class="col-8 text-end">
                            <h3 class="mb-0 fw-bold text-success">{{ $totalAprovacoes }}</h3>
                            <small class="text-muted">DISCIPLINAS APROVADAS</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="card summary-card border-top-danger">
                <div class="card-body py-3">
                    <div class="row align-items-center">
                        <div class="col-4">
                            <i class="fas fa-times-circle fa-2x text-danger"></i>
                        </div>
                        <div class="col-8 text-end">
                            <h3 class="mb-0 fw-bold text-danger">{{ $totalReprovacoes }}</h3>
                            <small class="text-muted">DISCIPLINAS REPROVADAS</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="card summary-card border-top-info">
                <div class="card-body py-3">
                    <div class="row align-items-center">
                        <div class="col-4">
                            <i class="fas fa-chart-line fa-2x text-info"></i>
                        </div>
                        <div class="col-8 text-end">
                            <h3 class="mb-0 fw-bold text-info">{{ $mediaGeralHistorico }}</h3>
                            <small class="text-muted">MÉDIA GERAL</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Progresso Académico --}}
    <div class="card mb-4">
        <div class="card-header bg-white">
            <i class="fas fa-chart-pie me-2 text-primary"></i>
            <strong>Progresso Académico</strong>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-8">
                    <div class="mb-3">
                        <div class="d-flex justify-content-between mb-1">
                            <small>Taxa de Aprovação</small>
                            <small>{{ $percentagemAprovacao }}%</small>
                        </div>
                        <div class="progress" style="height: 10px;">
                            <div class="progress-bar bg-success" style="width: {{ $percentagemAprovacao }}%"></div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="d-flex justify-content-between mb-1">
                            <small>Taxa de Reprovação</small>
                            <small>{{ $percentagemReprovacao }}%</small>
                        </div>
                        <div class="progress" style="height: 10px;">
                            <div class="progress-bar bg-danger" style="width: {{ $percentagemReprovacao }}%"></div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 text-center">
                    <div class="border rounded p-3 bg-light">
                        <i class="fas fa-graduation-cap fa-3x text-primary mb-2"></i>
                        <h5 class="mb-0">{{ $totalDisciplinas }}</h5>
                        <small class="text-muted">Total de Disciplinas Cursadas</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Histórico por Ano Lectivo --}}
    @forelse($historico as $ano)
    <div class="card mb-4">
        <div class="card-header bg-white">
            <div class="d-flex justify-content-between align-items-center flex-wrap">
                <div>
                    <i class="fas fa-calendar-alt me-2 text-primary"></i>
                    <strong>Ano Lectivo: {{ $ano['ano_lectivo'] }}</strong>
                    <span class="badge bg-secondary ms-2">{{ $ano['turma']->nome ?? 'Turma não definida' }}</span>
                </div>
                <div>
                    <span class="badge bg-{{ $ano['situacao'] == 'aprovado' ? 'success' : ($ano['situacao'] == 'exame' ? 'warning' : 'danger') }} fs-6">
                        <i class="fas fa-{{ $ano['situacao'] == 'aprovado' ? 'check-circle' : ($ano['situacao'] == 'exame' ? 'exclamation-triangle' : 'times-circle') }} me-1"></i>
                        {{ ucfirst($ano['situacao']) }}
                    </span>
                </div>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Disciplina</th>
                            <th class="text-center">1º Trim</th>
                            <th class="text-center">2º Trim</th>
                            <th class="text-center">3º Trim</th>
                            <th class="text-center">Média Final</th>
                            <th class="text-center">Faltas</th>
                            <th class="text-center">Situação</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($ano['disciplinas'] as $disciplina)
                        @php
                            $nota1 = $disciplina['notas_trimestres']['1'];
                            $nota2 = $disciplina['notas_trimestres']['2'];
                            $nota3 = $disciplina['notas_trimestres']['3'];
                            
                            $situacaoClass = match($disciplina['situacao']) {
                                'aprovado' => 'success',
                                'exame' => 'warning',
                                default => 'danger'
                            };
                            $situacaoIcon = match($disciplina['situacao']) {
                                'aprovado' => 'fa-check-circle',
                                'exame' => 'fa-exclamation-triangle',
                                default => 'fa-times-circle'
                            };
                        @endphp
                        <tr>
                            <td>
                                <strong>{{ $disciplina['disciplina']->nome }}</strong>
                                <br>
                                <small class="text-muted">{{ $disciplina['disciplina']->codigo }}</small>
                            </td>
                            <td class="text-center">
                                {{ number_format($nota1->media_trimestral ?? 0, 1) }}
                            </td>
                            <td class="text-center">
                                {{ number_format($nota2->media_trimestral ?? 0, 1) }}
                             </td>
                            <td class="text-center">
                                {{ number_format($nota3->media_trimestral ?? 0, 1) }}
                             </td>
                            <td class="text-center">
                                <strong class="text-{{ $disciplina['media_final'] >= 10 ? 'success' : 'danger' }}">
                                    {{ number_format($disciplina['media_final'], 1) }}
                                </strong>
                             </td>
                            <td class="text-center">{{ $disciplina['total_faltas'] }}</td>
                            <td class="text-center">
                                <span class="badge bg-{{ $situacaoClass }}">
                                    <i class="fas {{ $situacaoIcon }} me-1"></i>
                                    {{ ucfirst($disciplina['situacao']) }}
                                </span>
                             </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="table-light">
                        <tr>
                            <td colspan="6" class="text-end">
                                <strong>Média Geral do Ano: {{ $ano['media_geral'] }}</strong>
                             </td>
                            <td class="text-center">
                                <span class="badge bg-{{ $ano['situacao'] == 'aprovado' ? 'success' : ($ano['situacao'] == 'exame' ? 'warning' : 'danger') }}">
                                    {{ ucfirst($ano['situacao']) }}
                                </span>
                             </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
    @empty
    <div class="card">
        <div class="card-body text-center py-5">
            <i class="fas fa-history fa-4x text-muted mb-3 d-block"></i>
            <h5 class="text-muted">Nenhum registo encontrado</h5>
            <p class="text-muted small">O aluno ainda não possui histórico escolar.</p>
        </div>
    </div>
    @endforelse

    {{-- Botão para imprimir --}}
    @if(count($historico) > 0)
    <div class="fixed-bottom mb-3 me-3 text-end">
        <button onclick="window.print()" class="btn btn-primary rounded-circle shadow" style="width: 50px; height: 50px;">
            <i class="fas fa-print"></i>
        </button>
    </div>
    @endif
</div>
@endsection

@push('styles')
<style>
    .summary-card {
        border: none;
        border-radius: 16px;
        transition: all 0.2s ease;
        background: white;
        box-shadow: 0 1px 3px rgba(0,0,0,0.08);
    }
    
    .summary-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }
    
    .border-top-primary { border-top: 3px solid #1e3a8a !important; }
    .border-top-success { border-top: 3px solid #22c55e !important; }
    .border-top-danger { border-top: 3px solid #ef4444 !important; }
    .border-top-info { border-top: 3px solid #3b82f6 !important; }
    
    @media print {
        .navbar, .sidebar, .topbar, .btn-print-float, .fixed-bottom, .btn-group, .btn, .card-header .badge:last-child {
            display: none !important;
        }
        
        .sidebar, .main-content {
            margin-left: 0 !important;
            padding: 0 !important;
        }
        
        .card {
            box-shadow: none !important;
            border: 1px solid #ddd !important;
            break-inside: avoid;
        }
        
        .summary-card {
            box-shadow: none !important;
            border: 1px solid #ddd !important;
        }
        
        body {
            background: white !important;
            padding: 0 !important;
            margin: 0 !important;
        }
        
        .container-fluid {
            padding: 0 !important;
        }
    }
</style>
@endpush