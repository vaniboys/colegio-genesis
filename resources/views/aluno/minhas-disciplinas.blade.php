@extends('layouts.aluno')

@section('content')
<div class="card">
    <div class="card-header">
        <i class="fas fa-book-open me-2"></i> Minhas Disciplinas
    </div>
    <div class="card-body">
        @if(isset($disciplinas) && $disciplinas->count() > 0)
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Código</th>
                            <th>Disciplina</th>
                            <th>Carga Horária</th>
                            <th>Obrigatória</th>
                            <th>Professor</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($disciplinas as $disciplina)
                        @php
                            $professor = \App\Models\Professor::find($disciplina->pivot->professor_id);
                        @endphp
                        <tr>
                            <td><span class="badge bg-secondary">{{ $disciplina->codigo ?? '---' }}</span></td>
                            <td>
                                <strong>{{ $disciplina->nome }}</strong>
                            </td>
                            <td>
                                {{ $disciplina->pivot->carga_horaria_semanal ?? 4 }} horas/semana
                            </td>
                            <td>
                                @if($disciplina->pivot->obrigatoria)
                                    <span class="badge bg-success">Obrigatória</span>
                                @else
                                    <span class="badge bg-secondary">Opcional</span>
                                @endif
                            </td>
                            <td>
                                @if($professor)
                                    <i class="fas fa-chalkboard-teacher me-1 text-primary"></i>
                                    {{ $professor->nome_completo }}
                                @else
                                    <span class="text-muted">
                                        <i class="fas fa-clock me-1"></i> A aguardar atribuição
                                    </span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="table-light">
                        <tr>
                            <td colspan="5" class="text-end">
                                <small class="text-muted">
                                    <i class="fas fa-info-circle me-1"></i>
                                    Total de disciplinas: {{ $disciplinas->count() }}
                                </small>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        @else
            <div class="alert alert-info text-center">
                <i class="fas fa-info-circle"></i> Nenhuma disciplina associada à sua turma.
            </div>
        @endif
    </div>
</div>
@endsection