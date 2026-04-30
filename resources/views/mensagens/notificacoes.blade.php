@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5><i class="fas fa-bell me-2"></i> Minhas Notificações</h5>
                        <a href="/mensagens" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left"></i> Voltar
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    @if($notificacoes->count() > 0)
                        <div class="list-group">
                            @foreach($notificacoes as $notificacao)
                            <div class="list-group-item {{ !$notificacao->lida ? 'list-group-item-primary' : '' }}">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="flex-grow-1">
                                        <strong>{{ $notificacao->titulo }}</strong>
                                        <small class="text-muted d-block">{{ $notificacao->created_at->diffForHumans() }}</small>
                                        <p class="mb-1">{{ $notificacao->mensagem }}</p>
                                    </div>
                                    @if(!$notificacao->lida)
                                        <button class="btn btn-sm btn-success ms-2" onclick="marcarComoLida({{ $notificacao->id }})">
                                            Marcar lida
                                        </button>
                                    @endif
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-bell-slash fa-3x text-muted mb-3"></i>
                            <p class="text-muted">Nenhuma notificação</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function marcarComoLida(id) {
        fetch('/mensagens/notificacao/marcar-lida/' + id, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json'
            }
        }).then(response => {
            if(response.ok) location.reload();
        });
    }
</script>
@endpush
@endsection