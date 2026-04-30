@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5><i class="fas fa-comments me-2"></i> Conversa com {{ $outroUser->name }}</h5>
                    <a href="/mensagens" class="btn btn-secondary btn-sm">Voltar</a>
                </div>
                <div class="card-body" style="height: 500px; overflow-y: auto;" id="mensagensContainer">
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
                    <form method="POST" action="/mensagens/enviar">
                        @csrf
                        <input type="hidden" name="conversa_id" value="{{ $conversa->id }}">
                        <div class="input-group">
                            <input type="text" name="mensagem" class="form-control" placeholder="Digite sua mensagem..." required>
                            <button type="submit" class="btn btn-primary"><i class="fas fa-paper-plane"></i></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    var container = document.getElementById('mensagensContainer');
    container.scrollTop = container.scrollHeight;
</script>
@endsection