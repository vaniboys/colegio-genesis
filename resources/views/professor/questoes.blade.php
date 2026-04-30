@extends('layouts.professor')

@section('content')
<div class="table-card">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="mb-0" style="color: #1e3a8a;">
            <i class="fas fa-question-circle me-2"></i> Questões - {{ $avaliacao->titulo }}
        </h5>
        <button class="btn-sm-custom" data-bs-toggle="modal" data-bs-target="#novaQuestaoModal">
            <i class="fas fa-plus"></i> Nova Questão
        </button>
    </div>
    
    @if($avaliacao->questoes->count() > 0)
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Pergunta</th>
                        <th>Tipo</th>
                        <th>Pontos</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($avaliacao->questoes as $questao)
                    <tr>
                        <td>{{ Str::limit($questao->pergunta, 80) }}</td>
                        <td>
                            <span class="badge bg-primary">
                                {{ ucfirst(str_replace('_', ' ', $questao->tipo)) }}
                            </span>
                        </td>
                        <td>{{ $questao->pontos }} pts</td>
                        <td>
                            <form action="{{ route('professor.questao.deletar', $questao->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-sm-custom" style="background: #dc2626;" 
                                        onclick="return confirm('Deletar esta questão?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="alert alert-info">
            <i class="fas fa-info-circle"></i> Nenhuma questão adicionada.
        </div>
    @endif
</div>

<!-- Modal Nova Questão -->
<div class="modal fade" id="novaQuestaoModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Nova Questão</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="{{ route('professor.questao.salvar') }}">
                @csrf
                <input type="hidden" name="avaliacao_id" value="{{ $avaliacao->id }}">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Pergunta</label>
                        <textarea name="pergunta" class="form-control" rows="3" required></textarea>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Tipo</label>
                            <select name="tipo" class="form-control" id="tipoQuestao" required>
                                <option value="multipla_escolha">Múltipla Escolha</option>
                                <option value="verdadeiro_falso">Verdadeiro/Falso</option>
                                <option value="dissertativa">Dissertativa</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Pontos</label>
                            <input type="number" name="pontos" class="form-control" value="5" required>
                        </div>
                    </div>
                    <div id="opcoesDiv" style="display: none;">
                        <div class="mb-3">
                            <label class="form-label">Opções (uma por linha)</label>
                            <textarea name="opcoes" class="form-control" rows="4" placeholder="Opção A&#10;Opção B&#10;Opção C&#10;Opção D"></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Resposta Correta</label>
                            <input type="text" name="resposta_correta" class="form-control" placeholder="Ex: Opção A">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn-primary-custom">Salvar Questão</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.getElementById('tipoQuestao').addEventListener('change', function() {
        let opcoesDiv = document.getElementById('opcoesDiv');
        if(this.value === 'multipla_escolha') {
            opcoesDiv.style.display = 'block';
        } else {
            opcoesDiv.style.display = 'none';
        }
    });
</script>
@endsection