@extends('layouts.professor')

@section('content')
<div class="table-card">
    <h5 class="mb-3" style="color: #1e3a8a;">
        <i class="fas fa-plus me-2"></i> Nova Tarefa - {{ $turma->nome }}
    </h5>
    
    <form method="POST" action="{{ route('professor.tarefa.salvar') }}" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="turma_id" value="{{ $turma->id }}">
        
        <div class="mb-3">
            <label class="form-label">Título</label>
            <input type="text" name="titulo" class="form-control" required>
        </div>
        
        <div class="mb-3">
            <label class="form-label">Descrição</label>
            <textarea name="descricao" class="form-control" rows="5" required></textarea>
        </div>
        
        <div class="mb-3">
            <label class="form-label">Arquivo da Tarefa (PDF, DOC, etc)</label>
            <input type="file" name="arquivo" class="form-control" accept=".pdf,.doc,.docx,.jpg,.png">
            <small class="text-muted">Upload do arquivo da tarefa (máx 10MB)</small>
        </div>
        
        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Data de Entrega</label>
                <input type="date" name="data_entrega" class="form-control" required>
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">Pontuação Máxima</label>
                <input type="number" name="pontuacao_maxima" class="form-control" value="100" required>
            </div>
        </div>
        
        <div class="mb-3 form-check">
            <input type="checkbox" name="publicado" class="form-check-input" id="publicado">
            <label class="form-check-label" for="publicado">Publicar imediatamente</label>
        </div>
        
        <button type="submit" class="btn-sm-custom">
            <i class="fas fa-save"></i> Salvar
        </button>
        <a href="{{ route('professor.tarefas', $turma->id) }}" class="btn-back">
            Cancelar
        </a>
    </form>
</div>
@endsection