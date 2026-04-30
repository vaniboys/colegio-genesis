@extends('layouts.professor')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">
            <i class="fas fa-check-circle me-2"></i> Entregas - {{ $tarefa->titulo }}
        </h5>
        <a href="{{ route('professor.tarefas', $tarefa->turma_id) }}" class="btn-back">
            <i class="fas fa-arrow-left"></i> Voltar
        </a>
    </div>
    <div class="card-body p-0">
        @if($entregas->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Aluno</th>
                            <th>Arquivo</th>
                            <th>Comentário</th>
                            <th>Data Entrega</th>
                            <th>Nota</th>
                            <th>Status</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($entregas as $entrega)
                        <tr>
                            <td>{{ $entrega->aluno->nome_completo }}</td>
                            <td>
                                @if($entrega->arquivo)
                                    <a href="{{ Storage::url($entrega->arquivo) }}" class="btn btn-sm btn-primary" target="_blank">
                                        <i class="fas fa-download"></i> Baixar
                                    </a>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>{{ Str::limit($entrega->comentario, 50) }}</td>
                            <td class="text-center">
                                @if($entrega->data_entrega)
                                    {{ date('d/m/Y H:i', strtotime($entrega->data_entrega)) }}
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td class="text-center">
                                @if($entrega->nota)
                                    <strong>{{ $entrega->nota }}</strong>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <span class="badge bg-{{ $entrega->status == 'corrigido' ? 'success' : 'warning' }}">
                                    {{ ucfirst($entrega->status) }}
                                </span>
                            </td>
                            <td class="text-center">
                                <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#modalCorrigir{{ $entrega->id }}">
                                    <i class="fas fa-edit"></i> Corrigir
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-center py-5">
                <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                <p class="text-muted">Nenhuma entrega ainda</p>
            </div>
        @endif
    </div>
</div>

<!-- Modais de correção -->
@foreach($entregas as $entrega)
<div class="modal fade" id="modalCorrigir{{ $entrega->id }}" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="{{ route('professor.tarefa.corrigir', $entrega->id) }}">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Corrigir Entrega - {{ $entrega->aluno->nome_completo }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nota (0 - {{ $tarefa->pontuacao_maxima }})</label>
                        <input type="number" name="nota" class="form-control" 
                               value="{{ $entrega->nota }}" 
                               min="0" max="{{ $tarefa->pontuacao_maxima }}" 
                               step="0.5" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Feedback</label>
                        <textarea name="feedback" class="form-control" rows="3">{{ $entrega->feedback }}</textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Salvar Correção</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach
@endsection