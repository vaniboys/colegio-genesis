@extends('layouts.secretaria')

@section('content')
<div class="row">
    <div class="col-md-12">
        <h2>Dashboard da Secretaria</h2>
        <hr>
    </div>
</div>

<div class="row">
    <div class="col-md-3">
        <div class="card text-white bg-primary mb-3">
            <div class="card-body">
                <h5 class="card-title">Total de Alunos</h5>
                <p class="card-text display-4">{{ $totalAlunos }}</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-success mb-3">
            <div class="card-body">
                <h5 class="card-title">Professores</h5>
                <p class="card-text display-4">{{ $totalProfessores }}</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-warning mb-3">
            <div class="card-body">
                <h5 class="card-title">Turmas</h5>
                <p class="card-text display-4">{{ $totalTurmas }}</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-info mb-3">
            <div class="card-body">
                <h5 class="card-title">Matrículas {{ date('Y') }}</h5>
                <p class="card-text display-4">{{ $totalMatriculasAno }}</p>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <i class="fas fa-users"></i> Alunos por Turma
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead>
                            <tr><th>Turma</th><th>Alunos</th></tr>
                        </thead>
                        <tbody>
                            @foreach($alunosPorTurma as $turma)
                            <tr><td>{{ $turma->nome }}</td><td>{{ $turma->alunos_count }}</td></tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <i class="fas fa-clock"></i> Últimas Matrículas
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-sm mb-0">
                        <thead><tr><th>Aluno</th><th>Turma</th><th>Data</th></tr></thead>
                        <tbody>
                            @foreach($matriculasRecentes as $matricula)
                            <tr>
                                <td>{{ $matricula->aluno->nome_completo ?? 'N/A' }}</td>
                                <td>{{ $matricula->turma->nome ?? 'N/A' }}</td>
                                <td>
                                    @if($matricula->created_at)
                                        {{ $matricula->created_at->format('d/m/Y') }}
                                    @else
                                        {{ date('d/m/Y', strtotime($matricula->data_matricula)) }}
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection