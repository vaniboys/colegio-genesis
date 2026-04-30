@extends('layouts.professor')

@section('content')
<div class="table-card">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="mb-0" style="color: #1e3a8a;">
            <i class="fas fa-tasks me-2"></i> Avaliações - {{ $turma->nome }}
        </h5>
        <a href="{{ route('professor.avaliacao.criar', $turma->id) }}" class="btn-sm-custom">
            <i class="fas fa-plus"></i> Nova Avaliação
        </a>
    </div>
    
    @if($avaliacoes->count() > 0)
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Título</th>
                        <th>Tipo</th>
                        <th>Arquivo</th>
                        <th>Data Entrega</th>
                        <th>Pontuação</th>
                        <th>Status</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($avaliacoes as $avaliacao)
                    <tr>
                        <td>{{ $avaliacao->titulo }}</td>
                        <td>
                            <span class="badge bg-{{ $avaliacao->tipo == 'quiz' ? 'primary' : ($avaliacao->tipo == 'prova' ? 'warning' : 'info') }}">
                                {{ ucfirst($avaliacao->tipo) }}
                            </span>
                        </td>
                        <td>
                            @if($avaliacao->arquivo)
                                <a href="{{ Storage::url($avaliacao->arquivo) }}" class="btn-sm-custom" style="background: #10b981;" target="_blank">
                                    <i class="fas fa-download"></i> Baixar
                                </a>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>{{ date('d/m/Y', strtotime($avaliacao->data_entrega)) }}</td>
                        <td>{{ $avaliacao->pontuacao_maxima }} pts</td>
                        <td>
                            <span class="badge bg-{{ $avaliacao->publicado ? 'success' : 'secondary' }}">
                                {{ $avaliacao->publicado ? 'Publicado' : 'Rascunho' }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('professor.questoes', $avaliacao->id) }}" class="btn-sm-custom" style="background: #f59e0b;">
                                <i class="fas fa-question-circle"></i> Questões
                            </a>
                            <a href="{{ route('professor.avaliacao.editar', $avaliacao->id) }}" class="btn-sm-custom">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('professor.avaliacao.deletar', $avaliacao->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-sm-custom" style="background: #dc2626;" onclick="return confirm('Deletar esta avaliação?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="alert alert-info">
            <i class="fas fa-info-circle"></i> Nenhuma avaliação criada.
        </div>
    @endif
</div>
@endsection