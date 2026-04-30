@extends('layouts.professor')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span><i class="fas fa-envelope me-2"></i> Minhas Conversas</span>
        <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#novaConversaModal">
            <i class="fas fa-plus"></i> Nova Conversa
        </button>
    </div>
    <div class="card-body p-0">
        @if($conversas->count() > 0)
            @foreach($conversas as $conversa)
            <a href="{{ route('professor.conversa', $conversa->id) }}" class="text-decoration-none">
                <div class="d-flex justify-content-between align-items-center p-3 border-bottom hover-bg">
                    <div class="d-flex align-items-center gap-3">
                        <div class="conversa-avatar">
                            <i class="fas fa-user-circle fa-2x text-secondary"></i>
                        </div>
                        <div>
                            <strong>{{ $conversa->outroUser->name }}</strong><div class="small text-muted">
    @if($conversa->outroUser->role == 'professor')
        Professor
    @elseif($conversa->outroUser->role == 'aluno')
        Aluno
    @else
        {{ ucfirst($conversa->outroUser->role) }}
    @endif
</div>
                            @php $ultimaMsg = $conversa->mensagens->last(); @endphp
                            @if($ultimaMsg)
                                <small class="text-muted">{{ Str::limit($ultimaMsg->mensagem, 40) }}</small>
                            @endif
                        </div>
                    </div>
                    <div class="text-end">
                        @if($conversa->mensagens->where('lida', false)->where('user_id', '!=', auth()->id())->count() > 0)
                            <span class="badge bg-danger rounded-pill">
                                {{ $conversa->mensagens->where('lida', false)->where('user_id', '!=', auth()->id())->count() }}
                            </span>
                        @endif
                        <div class="small text-muted">
                            {{ $conversa->ultima_mensagem ? $conversa->ultima_mensagem->diffForHumans() : 'Sem mensagens' }}
                        </div>
                    </div>
                </div>
            </a>
            @endforeach
        @else
            <div class="text-center py-5">
                <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                <p class="text-muted">Nenhuma conversa ainda</p>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#novaConversaModal">
                    <i class="fas fa-plus"></i> Iniciar conversa com um aluno
                </button>
            </div>
        @endif
    </div>
</div>

<!-- Modal Nova Conversa - Apenas alunos da turma -->
<div class="modal fade" id="novaConversaModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-user-plus me-2"></i> Nova Conversa</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-info">
                    <i class="fas fa-info-circle me-2"></i>
                    Você só pode conversar com alunos da sua turma.
                </div>
                <div class="mb-3">
                    <label class="form-label">Selecione o aluno</label>
                    <select id="alunoSelect" class="form-control" required>
                        <option value="">Carregando alunos...</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" onclick="iniciarConversa()">
                    <i class="fas fa-comment"></i> Iniciar Conversa
                </button>
            </div>
        </div>
    </div>
</div>

<style>
    .hover-bg:hover {
        background-color: #f8f9fa;
        transform: translateX(5px);
        transition: all 0.3s;
    }
    .conversa-avatar {
        width: 45px;
        text-align: center;
    }
</style>

@push('scripts')
<script>
   function carregarAlunos() {
    fetch('{{ route("professor.buscar-alunos") }}')
        .then(response => response.json())
        .then(data => {
            let select = document.getElementById('alunoSelect');
            if(data.length > 0) {
                select.innerHTML = '<option value="">Selecione um aluno...</option>';
                data.forEach(aluno => {
                    select.innerHTML += `<option value="${aluno.id}">${aluno.name} (${aluno.email})</option>`;
                });
            } else {
                select.innerHTML = '<option value="">Nenhum aluno encontrado - Você não tem turmas ou alunos</option>';
            }
        })
        .catch(error => {
            console.error('Erro:', error);
            document.getElementById('alunoSelect').innerHTML = '<option value="">Erro ao carregar alunos</option>';
        });
}
    
    function iniciarConversa() {
        let alunoId = document.getElementById('alunoSelect').value;
        if(!alunoId) {
            alert('Selecione um aluno');
            return;
        }
        
        let form = document.createElement('form');
        form.method = 'POST';
        form.action = '{{ route("professor.nova-conversa") }}';
        form.innerHTML = '@csrf<input type="hidden" name="user_id" value="' + alunoId + '">';
        document.body.appendChild(form);
        form.submit();
    }
    
    // Carregar contagem de mensagens não lidas
    function carregarCounts() {
        fetch('{{ route("professor.mensagens.count") }}')
            .then(r => r.json())
            .then(d => {
                let badge = document.getElementById('topMensagensBadge');
                if(d.count > 0) { badge.textContent = d.count; badge.style.display = 'inline-block'; }
                else { badge.style.display = 'none'; }
            });
        
        fetch('{{ route("professor.notificacoes.count") }}')
            .then(r => r.json())
            .then(d => {
                let badge = document.getElementById('topNotificacoesBadge');
                if(d.count > 0) { badge.textContent = d.count; badge.style.display = 'inline-block'; }
                else { badge.style.display = 'none'; }
            });
    }
    
    document.addEventListener('DOMContentLoaded', function() {
        carregarAlunos();
        carregarCounts();
        setInterval(carregarCounts, 30000);
    });
</script>
@endpush
@endsection