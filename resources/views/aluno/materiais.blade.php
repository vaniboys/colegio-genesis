@extends('layouts.aluno')

@section('content')
<div class="card">
    <div class="card-header">
        <i class="fas fa-folder-open me-2"></i> Materiais Didáticos
    </div>
    <div class="card-body">
        @if($materiais->count() > 0)
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Título</th>
                            <th>Descrição</th>
                            <th>Tipo</th>
                            <th>Data</th>
                            <th>Ação</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($materiais as $material)
                        <tr>
                            <td>{{ $material->titulo }}</td>
                            <td>{{ $material->descricao }}</td>
                            <td><span class="badge bg-info">{{ strtoupper($material->tipo) }}</span></td>
                            <td>{{ $material->created_at ? $material->created_at->format('d/m/Y') : date('d/m/Y') }}</td>
                            <td>
                                <a href="{{ route('aluno.material.download', $material->id) }}" class="btn btn-sm btn-primary">
                                    <i class="fas fa-download"></i> Baixar
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="alert alert-info text-center">
                <i class="fas fa-info-circle"></i> Nenhum material disponível no momento.
            </div>
        @endif
    </div>
</div>
@endsection