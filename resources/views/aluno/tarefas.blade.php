@extends('layouts.aluno')

@section('content')
<div class="card">
    <div class="card-header">
        <i class="fas fa-tasks me-2"></i> Minhas Tarefas
    </div>
    <div class="card-body p-0">
        @if($tarefas->count() > 0)
            @foreach($tarefas as $tarefa)
            <div class="p-3 border-bottom">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <strong>{{ $tarefa->titulo }}</strong>
                        <p class="small text-muted mb-1">{{ Str::limit($tarefa->descricao, 100) }}</p>
                        <small class="text-muted">
                            <i class="fas fa-calendar"></i> Entrega: {{ date('d/m/Y', strtotime($tarefa->data_entrega)) }}
                        </small>
                    </div>
                    <div>
                        @php
                            $entrega = $tarefa->entregas->where('aluno_id', auth()->user()->aluno_id)->first();
                        @endphp
                        
                        @if($entrega && $entrega->status == 'corrigido')
                            <span class="badge bg-success">Nota: {{ $entrega->nota }}</span>
                        @elseif($entrega && $entrega->status == 'entregue')
                            <span class="badge bg-warning">Entregue</span>
                        @else
                            <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#modalEntrega{{ $tarefa->id }}">
                                <i class="fas fa-upload"></i> Enviar
                            </button>
                        @endif
                    </div>
                </div>
            </div>
            
            <!-- Modal de Entrega -->
            <div class="modal fade" id="modalEntrega{{ $tarefa->id }}" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form method="POST" action="{{ route('aluno.tarefa.enviar') }}" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="tarefa_id" value="{{ $tarefa->id }}">
                            <div class="modal-header">
                                <h5 class="modal-title">Enviar Tarefa: {{ $tarefa->titulo }}</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label class="form-label">Arquivo</label>
                                    <input type="file" name="arquivo" class="form-control" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Comentário</label>
                                    <textarea name="comentario" class="form-control" rows="2"></textarea>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                <button type="submit" class="btn btn-primary">Enviar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
        @else
            <div class="text-center py-5">
                <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                <p class="text-muted">Nenhuma tarefa disponível</p>
            </div>
        @endif
    </div>
</div>
@endsection