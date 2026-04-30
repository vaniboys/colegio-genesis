@extends('layouts.professor')

@section('content')
<div class="table-card">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="mb-0" style="color: #1e3a8a;">
            <i class="fas fa-file-alt me-2"></i> Tarefas - {{ $turma->nome }}
        </h5>
        <a href="{{ route('professor.tarefa.criar', $turma->id) }}" class="btn-sm-custom">
            <i class="fas fa-plus"></i> Nova Tarefa
        </a>
    </div>
    
    @if(isset($tarefas) && $tarefas->count() > 0)
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Título</th>
                        <th>Descrição</th>
                        <th>Arquivo</th>
                        <th>Data Entrega</th>
                        <th>Pontuação</th>
                        <th>Entregas</th>
                        <th>Status</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($tarefas as $tarefa)
                    <tr>
                        <td><strong>{{ $tarefa->titulo }}</strong></td>
                        <td>{{ Str::limit($tarefa->descricao, 50) }}</td>
                        <td>
                            @if($tarefa->arquivo)
                                <a href="{{ Storage::url($tarefa->arquivo) }}" class="btn-sm-custom" style="background: #10b981;" target="_blank">
                                    <i class="fas fa-download"></i> Baixar
                                </a>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>{{ date('d/m/Y', strtotime($tarefa->data_entrega)) }}</td>
                        <td>{{ $tarefa->pontuacao_maxima }} pts</td>
                        <td>
                            <span class="badge bg-primary">
                                {{ $tarefa->entregas->count() }} / {{ $turma->matriculas->count() }}
                            </span>
                        </td>
                        <td>
                            <span class="badge bg-{{ $tarefa->publicado ? 'success' : 'secondary' }}">
                                {{ $tarefa->publicado ? 'Publicado' : 'Rascunho' }}
                            </span>
                        </td>
                        <td>
                            <div class="d-flex gap-1">
                                <a href="{{ route('professor.tarefa.entregas', $tarefa->id) }}" class="btn-sm-custom" style="background: #f59e0b;">
                                    <i class="fas fa-check-circle"></i> Corrigir
                                </a>
                                <a href="{{ route('professor.tarefa.editar', $tarefa->id) }}" class="btn-sm-custom">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('professor.tarefa.deletar', $tarefa->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-sm-custom" style="background: #dc2626;" onclick="return confirm('Deletar esta tarefa?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="alert alert-info">
            <i class="fas fa-info-circle"></i> Nenhuma tarefa criada.
        </div>
    @endif
</div>
@endsection