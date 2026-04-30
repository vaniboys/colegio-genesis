@extends('layouts.aluno')

@section('content')
<div class="card">
    <div class="card-header d-flex align-items-center gap-3">
        <a href="{{ route('aluno.mensagens') }}" class="btn btn-sm btn-outline-secondary">
            <i class="fas fa-arrow-left"></i> Voltar
        </a>
        <div>
            <strong>{{ $outroUser->name }}</strong>
            <div class="small text-muted">
                @if($outroUser->role == 'professor') Professor
                @elseif($outroUser->role == 'aluno') Aluno
                @else {{ ucfirst($outroUser->role) }}
                @endif
            </div>
        </div>
    </div>
    
    <div class="card-body" style="height: 450px; overflow-y: auto;" id="mensagensContainer">
        @foreach($mensagens as $msg)
        @php $isMine = $msg->user_id == auth()->id(); @endphp
        <div class="mb-3 d-flex {{ $isMine ? 'justify-content-end' : 'justify-content-start' }}">
            <div class="p-3 rounded-3" style="max-width: 70%; {{ $isMine ? 'background: #3b82f6; color: white;' : 'background: #f1f5f9; color: #1e293b;' }}">
                <div>{{ $msg->mensagem }}</div>
                <small class="d-block mt-1 {{ $isMine ? 'text-white-50' : 'text-muted' }}" style="font-size: 10px;">
                    {{ $msg->created_at->format('d/m/Y H:i') }} · {{ $isMine ? 'Você' : $outroUser->name }}
                </small>
            </div>
        </div>
        @endforeach
    </div>
    
    <div class="card-footer">
        <form method="POST" action="/aluno/mensagens/enviar">
            @csrf
            <input type="hidden" name="conversa_id" value="{{ $conversa->id }}">
            <div class="input-group">
                <input type="text" name="mensagem" class="form-control" placeholder="Digite sua mensagem..." required>
                <button type="submit" class="btn btn-primary"><i class="fas fa-paper-plane"></i></button>
            </div>
        </form>
    </div>
</div>

<script>
    var container = document.getElementById('mensagensContainer');
    container.scrollTop = container.scrollHeight;
</script>
@endsection