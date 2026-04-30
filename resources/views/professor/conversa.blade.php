@extends('layouts.professor')

@section('content')
<div class="card">
    <div class="card-header d-flex align-items-center gap-3">
        <a href="{{ route('professor.mensagens') }}" class="btn btn-sm btn-outline-secondary">
            <i class="fas fa-arrow-left"></i> Voltar
        </a>
        <div>
            <strong>{{ $outroUser->name }}</strong>
            <div class="small text-muted">Aluno</div>
        </div>
    </div>
    
    <div class="card-body" style="height: 450px; overflow-y: auto;" id="mensagensContainer">
        @foreach($mensagens as $msg)
        @php $isMine = $msg->user_id == auth()->id(); @endphp
        <div class="mb-3" style="text-align: {{ $isMine ? 'right' : 'left' }};">
            <div style="display: inline-block; max-width: 70%; padding: 12px; border-radius: 12px; 
                 {{ $isMine ? 'background: #3b82f6; color: white;' : 'background: #e5e7eb; color: #1e293b;' }}">
                <div>{{ $msg->mensagem }}</div>
                <small style="font-size: 10px; opacity: 0.7;">
                    {{ $msg->created_at->format('d/m/Y H:i') }}
                </small>
            </div>
        </div>
        @endforeach
    </div>
    
    <div class="card-footer">
        <form method="POST" action="/professor/mensagens/enviar">
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