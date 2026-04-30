@extends('layouts.professor')

@section('content')
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
                        <td><strong>{{ $turma->nome }}</strong></td>
                        <td>{{ $turma->classe->nome ?? 'N/A' }}</td>  {{-- ✅ CORRIGIDO --}}
                        <td>
                            <span class="badge-{{ $turma->turno == 'manha' ? 'manha' : 'tarde' }}">
                                {{ ucfirst($turma->turno) }}
                            </span>
                        </td>
                        <td>{{ $turma->alunos()->count() }}</td>
                        <td>
                            <div class="d-flex gap-1 flex-wrap">
                                <a href="{{ route('professor.notas', $turma->id) }}" class="btn-sm-custom">
                                    <i class="fas fa-edit"></i> Notas
                                </a>
                                <a href="{{ route('professor.materiais', $turma->id) }}" class="btn-sm-custom" style="background: #f59e0b;">
                                    <i class="fas fa-folder-open"></i> Materiais
                                </a>
                                <a href="{{ route('professor.avaliacoes', $turma->id) }}" class="btn-sm-custom" style="background: #10b981;">
                                    <i class="fas fa-tasks"></i> Avaliações
                                </a>
                                <a href="{{ route('professor.tarefas', $turma->id) }}" class="btn-sm-custom" style="background: #8b5cf6;">
                                    <i class="fas fa-file-alt"></i> Tarefas
                                </a>
                                <a href="{{ route('professor.turma.alunos', $turma->id) }}" class="btn-sm-custom" style="background: #8b5cf6;">
                                    <i class="fas fa-users"></i> Ver Alunos
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