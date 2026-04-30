@extends('layouts.professor')

@section('content')
<div class="row g-3 mb-4">
    <div class="col-md-3 col-sm-6">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="stat-value">{{ $turmas->count() }}</div>
                    <div class="stat-label">Minhas Turmas</div>
                </div>
                <div class="stat-icon" style="background: #e0e7ff; color: #1e3a8a;">
                    <i class="fas fa-chalkboard-user"></i>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 col-sm-6">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="stat-value">{{ $totalAlunos }}</div>
                    <div class="stat-label">Total de Alunos</div>
                </div>
                <div class="stat-icon" style="background: #dbeafe; color: #3b82f6;">
                    <i class="fas fa-users"></i>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 col-sm-6">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="stat-value">0</div>
                    <div class="stat-label">Notas Pendentes</div>
                </div>
                <div class="stat-icon" style="background: #fef3c7; color: #d97706;">
                    <i class="fas fa-clock"></i>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 col-sm-6">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="stat-value">0</div>
                    <div class="stat-label">Aulas Hoje</div>
                </div>
                <div class="stat-icon" style="background: #dcfce7; color: #16a34a;">
                    <i class="fas fa-calendar-day"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="table-card">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h6 class="mb-0" style="color: #1e3a8a;">
            <i class="fas fa-chalkboard-user me-2"></i> Minhas Turmas
        </h6>
    </div>
    
    @if($turmas->count() > 0)
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Turma</th>
                        <th>Classe</th>
                        <th>Turno</th>
                        <th>Alunos</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($turmas as $turma)
                    <tr>
                        <td>
                            <strong>{{ $turma->nome }}</strong>
                            @if($turma->curso)
                                <br>
                                <small class="text-muted">{{ $turma->curso->nome }}</small>
                            @endif
                        </td>
                        <td class="align-middle">
                            {{ $turma->classe->nome ?? $turma->classe_nome ?? 'N/A' }}
                        </td>
                        <td class="align-middle">
                            <span class="badge-{{ $turma->turno == 'manha' ? 'manha' : ($turma->turno == 'tarde' ? 'tarde' : 'noite') }}">
                                {{ ucfirst($turma->turno) }}
                            </span>
                        </td>
                        <td class="align-middle">
                            <span class="badge bg-primary">{{ $turma->matriculas()->count() }}</span>
                        </td>
                        <td class="align-middle">
                            <div class="d-flex gap-1 flex-wrap">
                                <a href="{{ route('professor.notas', $turma->id) }}" class="btn-sm-custom">
                                    <i class="fas fa-edit"></i> Lançar Notas
                                </a>
                                <a href="{{ route('professor.materiais', $turma->id) }}" class="btn-sm-custom" style="background: #f59e0b;">
                                    <i class="fas fa-folder-open"></i> Materiais
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="alert alert-info py-2">
            <i class="fas fa-info-circle"></i> Nenhuma turma atribuída.
        </div>
    @endif
</div>
@endsection