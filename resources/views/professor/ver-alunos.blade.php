@extends('layouts.professor')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">
            <i class="fas fa-users me-2"></i> Alunos da Turma - {{ $turma->nome }}
        </h5>
        <a href="{{ route('professor.turmas') }}" class="btn-back">
            <i class="fas fa-arrow-left"></i> Voltar
        </a>
    </div>
    <div class="card-body p-0">
        @if($alunos->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Processo</th>
                            <th>Nome Completo</th>
                            <th>BI</th>
                            <th>Data Nascimento</th>
                            <th>Contacto</th>
                            <th>Email</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($alunos as $index => $aluno)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $aluno->processo ?? '-' }}</td>
                            <td><strong>{{ $aluno->nome_completo }}</strong></td>
                            <td>{{ $aluno->bi ?? '-' }}</td>
                            <td>{{ $aluno->data_nascimento ? date('d/m/Y', strtotime($aluno->data_nascimento)) : '-' }}</td>
                            {{-- ✅ Usa colunas que existem --}}
                            <td>{{ $aluno->telefone ?? $aluno->contacto_principal ?? '-' }}</td>
                            <td>{{ $aluno->email ?? '-' }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="p-3 bg-light">
                <strong>Total de Alunos:</strong> {{ $alunos->count() }}
            </div>
        @else
            <div class="text-center py-5">
                <i class="fas fa-users-slash fa-3x text-muted mb-3"></i>
                <p class="text-muted">Nenhum aluno matriculado nesta turma</p>
            </div>
        @endif
    </div>
</div>
@endsection