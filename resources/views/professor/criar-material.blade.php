@extends('layouts.professor')

@section('content')
<div class="table-card">
    <h5 class="mb-3" style="color: #1e3a8a;">
        <i class="fas fa-upload me-2"></i> Enviar Material - {{ $turma->nome }}
    </h5>
    
    <form method="POST" action="{{ route('professor.materiais.salvar') }}" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="turma_id" value="{{ $turma->id }}">
        
        <div class="mb-3">
            <label class="form-label">Título</label>
            <input type="text" name="titulo" class="form-control" required>
        </div>
        
        <div class="mb-3">
            <label class="form-label">Descrição</label>
            <textarea name="descricao" class="form-control" rows="3"></textarea>
        </div>
        
        <div class="mb-3">
            <label class="form-label">Arquivo (PDF, DOC, PPT, etc)</label>
            <input type="file" name="arquivo" class="form-control" required>
            <small class="text-muted">Máximo 10MB</small>
        </div>
        
        <button type="submit" class="btn-sm-custom">
            <i class="fas fa-cloud-upload-alt"></i> Enviar
        </button>
        <a href="{{ route('professor.materiais', $turma->id) }}" class="btn-back">
            Cancelar
        </a>
    </form>
</div>
@endsection