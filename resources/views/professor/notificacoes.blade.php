@extends('layouts.professor')

@section('content')
<div class="card">
    <div class="card-header">
        <i class="fas fa-bell me-2"></i> Minhas Notificações
    </div>
    <div class="card-body p-0">
        @if($notificacoes->count() > 0)
            @foreach($notificacoes as $notificacao)
            <div class="p-3 border-bottom {{ !$notificacao->lida ? 'bg-light' : '' }}">
                <div class="d-flex justify-content-between">
                    <strong>{{ $notificacao->titulo }}</strong>
                    <small class="text-muted">{{ $notificacao->created_at->diffForHumans() }}</small>
                </div>
                <p class="mb-0 mt-1">{{ $notificacao->mensagem }}</p>
                @if($notificacao->link)
                    <a href="{{ $notificacao->link }}" class="btn btn-sm btn-link mt-2">Ver detalhes</a>
                @endif
            </div>
            @endforeach
        @else
            <div class="text-center py-5">
                <i class="fas fa-bell-slash fa-3x text-muted mb-3"></i>
                <p class="text-muted">Nenhuma notificação</p>
            </div>
        @endif
    </div>
</div>
@endsection