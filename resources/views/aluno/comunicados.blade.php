@extends('layouts.aluno')

@section('content')
<div class="content-card">
    <div class="card-header-custom"><i class="fas fa-bullhorn me-2"></i> Comunicados</div>
    <div class="p-3">
        @forelse($comunicados as $comunicado)
        <div class="comunicado-item mb-3">
            <div class="d-flex justify-content-between align-items-center mb-1">
                <strong>{{ $comunicado->titulo ?? 'Comunicado' }}</strong>
                <small class="text-muted">
                    @if($comunicado->created_at)
                        {{ date('d/m/Y H:i', strtotime($comunicado->created_at)) }}
                    @else
                        Data não disponível
                    @endif
                </small>
            </div>
            <p class="small mb-0">{{ $comunicado->mensagem ?? 'Sem conteúdo' }}</p>
        </div>
        @empty
        <div class="text-center text-muted py-4">
            <i class="fas fa-info-circle fa-2x mb-2 d-block"></i>
            <p>Nenhum comunicado disponível</p>
        </div>
        @endforelse
    </div>
</div>
@endsection