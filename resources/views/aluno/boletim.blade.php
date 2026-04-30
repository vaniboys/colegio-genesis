@extends('layouts.aluno')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <div>
            <i class="fas fa-file-alt me-2"></i> 
            <strong>Boletim Escolar - {{ date('Y') }}</strong>
        </div>
        <div>
            <button onclick="imprimirBoletim()" class="btn btn-primary">
                <i class="fas fa-print me-2"></i> Imprimir / Salvar PDF
            </button>
        </div>
    </div>
    <div class="card-body" id="boletim-content">
        <!-- Cabeçalho do Boletim -->
        <div class="text-center mb-4">
            <img src="{{ asset('images/logo.png') }}" alt="Logo" style="height: 80px;" onerror="this.style.display='none'">
            <h3 class="mt-2">Colégio Gênesis</h3>
            <p class="text-muted">Sistema de Gestão Escolar - Angola</p>
            <hr>
            <h5>Boletim de Notas - {{ date('Y') }}</h5>
            <p><strong>Aluno:</strong> {{ $aluno->nome_completo }} | 
               <strong>Processo:</strong> {{ $aluno->processo }} |
               <strong>Turma:</strong> {{ $matricula->turma->nome ?? 'N/A' }}</p>
        </div>

        <!-- Tabela de Notas -->
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th>Disciplina</th>
                        <th class="text-center">MAC</th>
                        <th class="text-center">Prova</th>
                        <th class="text-center">Média</th>
                        <th class="text-center">Exame</th>
                        <th class="text-center">Média Final</th>
                        <th class="text-center">Situação</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($notas as $nota)
                    <tr>
                        <td><strong>{{ $nota->disciplina->nome }}</strong></td>
                        {{-- ✅ Usa os nomes reais das colunas --}}
                        <td class="text-center">{{ number_format($nota->avaliacao_continua ?? 0, 1) }}</td>
                        <td class="text-center">{{ number_format($nota->prova_trimestral ?? 0, 1) }}</td>
                        <td class="text-center">{{ number_format($nota->media_trimestral ?? 0, 1) }}</td>
                        <td class="text-center">{{ $nota->exame_final ? number_format($nota->exame_final, 1) : '-' }}</td>
                        <td class="text-center">
                            <strong class="{{ ($nota->media_final ?? $nota->media_trimestral ?? 0) >= 10 ? 'text-success' : 'text-danger' }}">
                                {{ number_format($nota->media_final ?? $nota->media_trimestral ?? 0, 1) }}
                            </strong>
                        </td>
                        <td class="text-center">
                            {{-- ✅ Usa o campo situacao que já existe na tabela --}}
                            <span class="badge bg-{{ ($nota->situacao == 'aprovado') ? 'success' : (($nota->situacao == 'exame') ? 'warning' : 'danger') }}">
                                {{ $nota->situacao ?? 'Cursando' }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted">Nenhuma nota disponível</td>
                    </tr>
                    @endforelse
                </tbody>
                <tfoot class="table-light">
                    <tr>
                        <th colspan="5" class="text-end">Média Geral:</th>
                        <th class="text-center">
                            <strong class="text-{{ $mediaGeral >= 10 ? 'success' : 'danger' }}">
                                {{ number_format($mediaGeral ?? 0, 1) }}
                            </strong>
                        </th>
                        <th class="text-center">
                            <span class="badge bg-{{ $mediaGeral >= 10 ? 'success' : 'danger' }}">
                                {{ $mediaGeral >= 10 ? 'Aprovado' : 'Recuperação' }}
                            </span>
                        </th>
                    </tr>
                </tfoot>
            </table>
        </div>

        <!-- Resumo de Desempenho -->
        <div class="row mt-4">
            <div class="col-md-6">
                <div class="card bg-light">
                    <div class="card-body">
                        <h6><i class="fas fa-chart-line"></i> Resumo de Desempenho</h6>
                        <hr>
                        <p><strong>Melhor Nota:</strong> {{ number_format($melhorNota ?? 0, 1) }}</p>
                        <p><strong>Pior Nota:</strong> {{ number_format($piorNota ?? 0, 1) }}</p>
                        <p><strong>Total de Faltas:</strong> {{ $totalFaltas ?? 0 }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card bg-light">
                    <div class="card-body">
                        <h6><i class="fas fa-info-circle"></i> Legenda</h6>
                        <hr>
                        <p><span class="badge bg-success">≥ 10</span> - Aprovado</p>
                        <p><span class="badge bg-danger">&lt; 10</span> - Reprovado</p>
                        <p><span class="badge bg-warning">Recuperação</span> - Em exame final</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Assinaturas -->
        <div class="row mt-4 pt-3">
            <div class="col-md-4 text-center"><hr><small>Secretaria Escolar</small></div>
            <div class="col-md-4 text-center"><hr><small>Direção Pedagógica</small></div>
            <div class="col-md-4 text-center"><hr><small>Encarregado de Educação</small></div>
        </div>

        <!-- Rodapé -->
        <div class="text-center mt-4 pt-3 border-top">
            <small class="text-muted">
                Documento gerado pelo Sistema de Gestão Escolar - Colégio Gênesis<br>
                Emitido em: {{ date('d/m/Y H:i:s') }}
            </small>
        </div>
    </div>
</div>

<style>
    @media print {
        .navbar, .sidebar, .topbar, .card-header, .btn, footer { display: none !important; }
        .card { border: none !important; box-shadow: none !important; margin: 0 !important; padding: 0 !important; }
        .card-body { padding: 0 !important; }
        .badge { print-color-adjust: exact; -webkit-print-color-adjust: exact; }
        .table-bordered { border: 1px solid #000 !important; }
        @page { margin: 1.5cm; }
    }
</style>

<script>
    function imprimirBoletim() { window.print(); }
</script>
@endsection