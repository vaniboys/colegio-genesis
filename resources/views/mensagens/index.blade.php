@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5><i class="fas fa-envelope me-2"></i> Minhas Conversas</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 border-end">
                            <h6>Nova Conversa</h6>
                            <div class="mb-3">
                                <input type="text" id="buscarUsuario" class="form-control" placeholder="Buscar usuário...">
                                <div id="resultadoBusca" class="mt-2" style="display: none;"></div>
                            </div>
                            <hr>
                            <div class="conversas-list">
                                @forelse($conversas as $conversa)
                                <a href="/mensagens/conversa/{{ $conversa->id }}" class="text-decoration-none">
                                    <div class="p-2 mb-2 border rounded">
                                        <div class="d-flex justify-content-between">
                                            <strong>{{ $conversa->outroUser->name ?? 'Usuário' }}</strong>
                                            <small class="text-muted">{{ $conversa->ultima_mensagem ? $conversa->ultima_mensagem->diffForHumans() : '' }}</small>
                                        </div>
                                        <small class="text-muted">{{ $conversa->outroUser->role ?? '' }}</small>
                                    </div>
                                </a>
                                @empty
                                <p class="text-muted text-center">Nenhuma conversa</p>
                                @endforelse
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="text-center text-muted py-5">
                                <i class="fas fa-comments fa-3x mb-3"></i>
                                <p>Selecione uma conversa</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.getElementById('buscarUsuario').addEventListener('keyup', function() {
        let query = this.value;
        if(query.length >= 2) {
            fetch('/usuarios/buscar?q=' + query)
                .then(r => r.json())
                .then(data => {
                    let html = '';
                    data.forEach(function(user) {
                        html += `<div class="p-2 border-bottom" onclick="iniciarConversa(${user.id})" style="cursor: pointer;">
                                    <strong>${user.name}</strong><br>
                                    <small>${user.email}</small>
                                </div>`;
                    });
                    document.getElementById('resultadoBusca').innerHTML = html;
                    document.getElementById('resultadoBusca').style.display = 'block';
                });
        } else {
            document.getElementById('resultadoBusca').style.display = 'none';
        }
    });
    
    function iniciarConversa(userId) {
        let form = document.createElement('form');
        form.method = 'POST';
        form.action = '/mensagens/nova-conversa';
        form.innerHTML = '@csrf<input type="hidden" name="user_id" value="' + userId + '">';
        document.body.appendChild(form);
        form.submit();
    }
</script>
@endpush
@endsection