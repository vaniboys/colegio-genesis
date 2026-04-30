@extends('layouts.professor')

@section('content')
<div class="table-card">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="mb-0" style="color: #1e3a8a;">
            <i class="fas fa-folder-open me-2"></i> Materiais - {{ $turma->nome }}
        </h5>
        <a href="{{ route('professor.materiais.criar', $turma->id) }}" class="btn-sm-custom">
            <i class="fas fa-upload"></i> Enviar Material
        </a>
    </div>
    
    @if($materiais->count() > 0)
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Título</th>
                        <th>Descrição</th>
                        <th>Tipo</th>
                        <th>Downloads</th>
                        <th>Data</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($materiais as $material)
                    <tr>
                        <td>{{ $material->titulo }}</td>
                        <td>{{ Str::limit($material->descricao, 50) }}</td>
                        <td>
                            <span class="badge bg-secondary">
                                {{ strtoupper($material->tipo) }}
                            </span>
                         </td>
                        <td>{{ $material->downloads }}</td>
                        <td class="text-center">
                            @if($material->created_at)
                                {{ $material->created_at->format('d/m/Y') }}
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>
                            <div class="d-flex gap-1">
                                <a href="{{ route('professor.materiais.download', $material->id) }}" 
                                   class="btn-sm-custom" style="background: #10b981;">
                                    <i class="fas fa-download"></i> Baixar
                                </a>
                                <form action="{{ route('professor.materiais.deletar', $material->id) }}" 
                                      method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-sm-custom" style="background: #dc2626;" 
                                            onclick="return confirm('Deletar este material?')">
                                        <i class="fas fa-trash"></i> Deletar
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
            <i class="fas fa-info-circle"></i> Nenhum material enviado ainda.
        </div>
    @endif
    
    
</div>
@endsection