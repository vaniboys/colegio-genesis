@extends('layouts.professor')

@section('content')
<div class="table-card">
    <h5 class="mb-3" style="color: #1e3a8a;">
        <i class="fas fa-edit me-2"></i> Editar Avaliação
    </h5>
    
    <form method="POST" action="{{ route('professor.avaliacao.atualizar', $avaliacao->id) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <div class="mb-3">
            <label class="form-label">Título</label>
            <input type="text" name="titulo" class="form-control" value="{{ $avaliacao->titulo }}" required>
        </div>
        
        <div class="mb-3">
            <label class="form-label">Descrição</label>
            <textarea name="descricao" class="form-control" rows="3">{{ $avaliacao->descricao }}</textarea>
        </div>
        
        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Tipo</label>
                <select name="tipo" class="form-control" required>
                    <option value="quiz" {{ $avaliacao->tipo == 'quiz' ? 'selected' : '' }}>Quiz</option>
                    <option value="prova" {{ $avaliacao->tipo == 'prova' ? 'selected' : '' }}>Prova</option>
                    <option value="trabalho" {{ $avaliacao->tipo == 'trabalho' ? 'selected' : '' }}>Trabalho</option>
                </select>
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">Data de Entrega</label>
                <input type="date" name="data_entrega" class="form-control" value="{{ $avaliacao->data_entrega }}" required>
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Duração (minutos)</label>
                <input type="number" name="duracao" class="form-control" value="{{ $avaliacao->duracao }}">
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">Pontuação Máxima</label>
                <input type="number" name="pontuacao_maxima" class="form-control" value="{{ $avaliacao->pontuacao_maxima }}" required>
            </div>
        </div>
        
        <div class="mb-3 form-check">
            <input type="checkbox" name="publicado" class="form-check-input" id="publicado" {{ $avaliacao->publicado ? 'checked' : '' }}>
            <label class="form-check-label" for="publicado">Publicado</label>
        </div>
        
        <button type="submit" class="btn-sm-custom">
            <i class="fas fa-save"></i> Atualizar
        </button>
        <a href="{{ route('professor.avaliacoes', $avaliacao->turma_id) }}" class="btn-back">
            Cancelar
        </a>
    </form>
</div>
@endsection