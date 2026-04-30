@extends('layouts.aluno')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span><i class="fas fa-bell me-2"></i> Minhas Notificações</span>
        @if($notificacoes->where('lida', false)->count() > 0)
        <button class="btn btn-sm btn-primary" onclick="marcarTodasLidas()">
            <i class="fas fa-check-double"></i> Marcar todas como lidas
        </button>
        @endif
    </div>
    <div class="card-body p-0">
        @if($notificacoes->count() > 0)
            @foreach($notificacoes as $notificacao)
            <div class="notification-item p-3 border-bottom {{ !$notificacao->lida ? 'unread' : '' }}" data-id="{{ $notificacao->id }}">
                <div class="d-flex justify-content-between">
                    <div class="flex-grow-1">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <strong>{{ $notificacao->titulo }}</strong>
                            <small class="text-muted">{{ $notificacao->created_at->diffForHumans() }}</small>
                        </div>
                        <p class="mb-1">{{ $notificacao->mensagem }}</p>
                        @if($notificacao->link)
                            <a href="{{ $notificacao->link }}" class="btn btn-sm btn-outline-primary mt-2">
                                Ver detalhes <i class="fas fa-arrow-right ms-1"></i>
                            </a>
                        @endif
                    </div>
                    @if(!$notificacao->lida)
                        <button class="btn btn-sm btn-link text-success" onclick="marcarComoLida({{ $notificacao->id }})">
                            <i class="fas fa-check-circle"></i>
                        </button>
                    @endif
                </div>
            </div>
            @endforeach
        @else
            <div class="text-center py-5">
                <i class="fas fa-bell-slash fa-3x text-muted mb-3"></i>
                <p class="text-muted">Nenhuma notificação encontrada</p>
                <small class="text-muted">As notificações aparecerão aqui quando houver novidades</small>
            </div>
        @endif
    </div>
</div>

<style>
    .notification-item {
        transition: all 0.3s;
        cursor: pointer;
    }
    .notification-item:hover {
        background-color: #f8fafc;
        transform: translateX(5px);
    }
    .notification-item.unread {
        background-color: #e0e7ff;
        border-left: 3px solid #1e3a8a;
    }
</style>

@push('scripts')
<script>
    function marcarComoLida(id) {
        fetch('/aluno/notificacao/marcar-lida/' + id, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json'
            }
        }).then(response => {
            if(response.ok) {
                location.reload();
            }
        });
    }
    
    function marcarTodasLidas() {
        fetch('/aluno/notificacoes/marcar-todas', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json'
            }
        }).then(response => {
            if(response.ok) {
                location.reload();
            }
        });
    }
</script>
@endpush
@endsection