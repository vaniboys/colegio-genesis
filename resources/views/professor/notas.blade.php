@extends('layouts.professor')

@section('content')
<div class="table-card">
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
        <div>
            <h5 class="mb-0" style="color: #1e3a8a;">
                <i class="fas fa-edit me-2"></i> Lançar Notas - {{ $turma->nome }}
            </h5>
            <small class="text-muted">Registo de avaliações e notas dos alunos</small>
        </div>
        <div class="d-flex gap-2">
            <span class="badge bg-primary p-2">
                <i class="fas fa-calendar-alt me-1"></i> Ano Letivo: 2025
            </span>
        </div>
    </div>

    {{-- Barra de ferramentas com seletor de trimestre e disciplina --}}
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
        <div class="d-flex gap-3 flex-wrap">
            {{-- Seletor de Trimestre --}}
            <div class="btn-group" role="group">
                <a href="{{ route('professor.notas', ['turma' => $turma->id, 'trimestre' => 1, 'disciplina_id' => $disciplinaId ?? 1]) }}" 
                   class="btn btn-sm {{ $trimestre == 1 ? 'btn-primary' : 'btn-outline-primary' }}">
                    <i class="fas fa-calendar-week me-1"></i> 1º Trimestre
                </a>
                <a href="{{ route('professor.notas', ['turma' => $turma->id, 'trimestre' => 2, 'disciplina_id' => $disciplinaId ?? 1]) }}" 
                   class="btn btn-sm {{ $trimestre == 2 ? 'btn-primary' : 'btn-outline-primary' }}">
                    <i class="fas fa-calendar-week me-1"></i> 2º Trimestre
                </a>
                <a href="{{ route('professor.notas', ['turma' => $turma->id, 'trimestre' => 3, 'disciplina_id' => $disciplinaId ?? 1]) }}" 
                   class="btn btn-sm {{ $trimestre == 3 ? 'btn-primary' : 'btn-outline-primary' }}">
                    <i class="fas fa-calendar-week me-1"></i> 3º Trimestre
                </a>
            </div>
            
            {{-- Seletor de Disciplina --}}
            @if(isset($disciplinas) && $disciplinas->count() > 0)
            <div class="dropdown">
                <button class="btn btn-sm btn-outline-primary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                    <i class="fas fa-book me-1"></i> {{ $disciplinaSelecionada->nome ?? 'Selecionar Disciplina' }}
                </button>
                <ul class="dropdown-menu">
                    @foreach($disciplinas as $disciplina)
                        <li>
                            <a class="dropdown-item {{ ($disciplinaId ?? 1) == $disciplina->id ? 'active' : '' }}" 
                               href="{{ route('professor.notas', ['turma' => $turma->id, 'trimestre' => $trimestre, 'disciplina_id' => $disciplina->id]) }}">
                                <i class="fas fa-book me-2"></i> {{ $disciplina->nome }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
            @endif
            
            <div class="alert alert-info py-1 px-3 mb-0 d-flex align-items-center">
                <i class="fas fa-info-circle me-2"></i>
                <small>Média = (MAC + Prova) ÷ 2 | Exame: (Média + Exame) ÷ 2</small>
            </div>
        </div>
        
        <a href="{{ route('professor.turmas') }}" class="btn-back">
            <i class="fas fa-arrow-left"></i> Voltar
        </a>
    </div>
    
    @if($matriculas->count() > 0)
        <form method="POST" action="{{ route('professor.notas.salvar') }}" id="formNotas">
            @csrf
            <input type="hidden" name="turma_id" value="{{ $turma->id }}">
            <input type="hidden" name="trimestre" value="{{ $trimestre }}">
            <input type="hidden" name="disciplina_id" value="{{ $disciplinaId ?? 1 }}">
            
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th style="min-width: 220px">Aluno</th>
                            <th class="text-center" style="min-width: 120px">
                                <i class="fas fa-chart-line me-1"></i> MAC<br>
                                <small class="text-muted">Avaliação Contínua</small>
                            </th>
                            <th class="text-center" style="min-width: 120px">
                                <i class="fas fa-pen me-1"></i> Prova<br>
                                <small class="text-muted">Trimestral</small>
                            </th>
                            <th class="text-center" style="min-width: 90px">
                                <i class="fas fa-calculator me-1"></i> Média<br>
                                <small class="text-muted">Trimestral</small>
                            </th>
                            <th class="text-center" style="min-width: 120px">
                                <i class="fas fa-file-signature me-1"></i> Exame<br>
                                <small class="text-muted">Recuperação</small>
                            </th>
                            <th class="text-center" style="min-width: 90px">
                                <i class="fas fa-chart-simple me-1"></i> Média<br>
                                <small class="text-muted">Final</small>
                            </th>
                            <th class="text-center" style="min-width: 100px">
                                <i class="fas fa-calendar-times me-1"></i> Faltas<br>
                                <small class="text-muted">Absolutas</small>
                            </th>
                            <th class="text-center" style="min-width: 110px">
                                <i class="fas fa-flag-checkered me-1"></i> Situação
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($matriculas as $matricula)
                        @php
                            $nota = $matricula->notas->first();
                            $mac = $nota->avaliacao_continua ?? null;
                            $prova = $nota->prova_trimestral ?? null;
                            $mediaTrimestral = $nota->media_trimestral ?? null;
                            $exame = $nota->exame_final ?? null;
                            $mediaFinal = $nota->media_final ?? null;
                            $faltas = $nota->faltas ?? 0;
                            $situacao = $nota->situacao ?? 'cursando';
                            $totalAulas = 54;
                            $percentagemFaltas = $totalAulas > 0 ? min(100, round(($faltas / $totalAulas) * 100, 0)) : 0;
                            
                            // Número de matrícula - vem da tabela matriculas
                            $numeroMatricula = $matricula->numero_matricula ?? $matricula->id;
                        @endphp
                        <tr class="aluno-row" data-matricula-id="{{ $matricula->id }}">
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="avatar-circle me-2">
                                        <span class="avatar-text">{{ substr($matricula->aluno->nome_completo, 0, 1) }}</span>
                                    </div>
                                    <div>
                                        <strong>{{ $matricula->aluno->nome_completo }}</strong><br>
                                        <small class="text-muted">
                                            <i class="fas fa-id-card me-1"></i> 
                                            Matrícula: {{ $numeroMatricula }}
                                        </small>
                                    </div>
                                </div>
                            </td>
                            <td class="text-center">
                                <input type="number" 
                                       name="notas[{{ $matricula->id }}][avaliacao_continua]" 
                                       value="{{ $mac }}"
                                       class="form-control form-control-sm text-center nota-input mac-input" 
                                       step="0.5" min="0" max="20"
                                       data-matricula="{{ $matricula->id }}"
                                       placeholder="0-20">
                            </td>
                            <td class="text-center">
                                <input type="number" 
                                       name="notas[{{ $matricula->id }}][prova_trimestral]" 
                                       value="{{ $prova }}"
                                       class="form-control form-control-sm text-center nota-input prova-input" 
                                       step="0.5" min="0" max="20"
                                       data-matricula="{{ $matricula->id }}"
                                       placeholder="0-20">
                            </td>
                            <td class="text-center align-middle media-trimestral-cell" data-matricula="{{ $matricula->id }}">
                                <strong class="media-trimestral-valor" style="font-size: 1.1rem">
                                    {{ $mediaTrimestral ? number_format($mediaTrimestral, 1) : '—' }}
                                </strong>
                            </td>
                            <td class="text-center">
                                <input type="number" 
                                       name="notas[{{ $matricula->id }}][exame_final]" 
                                       value="{{ $exame }}"
                                       class="form-control form-control-sm text-center exame-input" 
                                       step="0.5" min="0" max="20"
                                       data-matricula="{{ $matricula->id }}"
                                       placeholder="Opcional">
                            </td>
                            <td class="text-center align-middle media-final-cell" data-matricula="{{ $matricula->id }}">
                                <strong class="media-final-valor" style="font-size: 1.1rem">
                                    {{ $mediaFinal ? number_format($mediaFinal, 1) : '—' }}
                                </strong>
                            </td>
                            <td class="text-center">
                                <div class="d-flex flex-column align-items-center">
                                    <input type="number" 
                                           name="notas[{{ $matricula->id }}][faltas]" 
                                           value="{{ $faltas }}"
                                           class="form-control form-control-sm text-center faltas-input mb-1" 
                                           min="0" style="width: 70px;">
                                    <div class="progress w-100" style="height: 6px;">
                                        <div class="progress-bar faltas-progress" 
                                             style="width: {{ $percentagemFaltas }}%; {{ $percentagemFaltas > 50 ? 'background-color: #dc2626' : ($percentagemFaltas > 25 ? 'background-color: #eab308' : 'background-color: #22c55e') }}">
                                        </div>
                                    </div>
                                    <small class="text-muted faltas-percent">
                                        {{ $percentagemFaltas }}% 
                                        @if($percentagemFaltas >= 50) 
                                            <i class="fas fa-exclamation-triangle text-danger"></i>
                                        @elseif($percentagemFaltas >= 25)
                                            <i class="fas fa-clock text-warning"></i>
                                        @endif
                                    </small>
                                </div>
                            </td>
                            <td class="text-center align-middle situacao-cell" data-matricula="{{ $matricula->id }}">
                                @include('components.situacao-badge', ['situacao' => $situacao])
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <div class="mt-4 d-flex justify-content-between align-items-center">
                <div class="d-flex gap-2">
                    <button type="submit" class="btn-sm-custom" id="btnSalvar">
                        <i class="fas fa-save"></i> Salvar Notas
                    </button>
                    <button type="button" class="btn-sm-outline" id="btnRecalcular">
                        <i class="fas fa-sync-alt"></i> Recalcular Médias
                    </button>
                    <button type="button" class="btn-sm-outline" id="btnPreencherZeros">
                        <i class="fas fa-fill-drip"></i> Preencher Zeros
                    </button>
                </div>
                
                <div id="autoSaveStatus" class="d-flex align-items-center gap-2">
                    <i class="fas fa-cloud-upload-alt text-muted"></i>
                    <span id="saveStatusText" class="small text-muted">Pronto</span>
                    <span id="saveSpinner" class="spinner-border spinner-border-sm text-primary d-none" role="status"></span>
                </div>
            </div>
        </form>
    @else
        <div class="alert alert-info">
            <i class="fas fa-info-circle"></i> Nenhum aluno matriculado nesta turma.
        </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // ==================== FUNÇÕES DE CÁLCULO ====================
    
    function calcularMediaTrimestral(mac, prova) {
        let macNum = parseFloat(mac) || 0;
        let provaNum = parseFloat(prova) || 0;
        let media = (macNum + provaNum) / 2;
        return Math.round(media * 10) / 10;
    }
    
    function calcularMediaFinal(mediaTrimestral, exame) {
        let exameNum = parseFloat(exame);
        if (!isNaN(exameNum) && exameNum > 0) {
            let media = (mediaTrimestral + exameNum) / 2;
            return Math.round(media * 10) / 10;
        }
        return mediaTrimestral;
    }
    
    function definirSituacao(mediaFinal, exame) {
        if (mediaFinal >= 10) {
            let temExame = exame && parseFloat(exame) > 0;
            return temExame ? 'aprovado_exame' : 'aprovado';
        } else if (mediaFinal >= 7) {
            return 'exame';
        } else {
            return 'reprovado';
        }
    }
    
    function getSituacaoHtml(situacao) {
        const config = {
            'aprovado': { class: 'bg-success', icon: 'fa-check-circle', text: 'Aprovado' },
            'aprovado_exame': { class: 'bg-info', icon: 'fa-star', text: 'Aprovado (Exame)' },
            'exame': { class: 'bg-warning text-dark', icon: 'fa-exclamation-triangle', text: 'Exame' },
            'reprovado': { class: 'bg-danger', icon: 'fa-times-circle', text: 'Reprovado' },
            'cursando': { class: 'bg-secondary', icon: 'fa-clock', text: 'Cursando' }
        };
        const c = config[situacao] || config.cursando;
        return `<span class="badge ${c.class} px-3 py-2"><i class="fas ${c.icon}"></i> ${c.text}</span>`;
    }
    
    // ==================== ATUALIZAR LINHA ====================
    
    function atualizarLinha(row) {
        let macInput = row.querySelector('.mac-input');
        let provaInput = row.querySelector('.prova-input');
        let exameInput = row.querySelector('.exame-input');
        let faltasInput = row.querySelector('.faltas-input');
        
        let mac = macInput ? macInput.value : 0;
        let prova = provaInput ? provaInput.value : 0;
        let exame = exameInput ? exameInput.value : null;
        let faltas = faltasInput ? parseInt(faltasInput.value) || 0 : 0;
        
        let mediaTrimestral = calcularMediaTrimestral(mac, prova);
        let mediaFinal = calcularMediaFinal(mediaTrimestral, exame);
        let situacao = definirSituacao(mediaFinal, exame);
        
        let mediaTrimCell = row.querySelector('.media-trimestral-valor');
        let mediaFinalCell = row.querySelector('.media-final-valor');
        
        if (mediaTrimCell) {
            mediaTrimCell.textContent = mediaTrimestral.toFixed(1);
            mediaTrimCell.style.color = mediaTrimestral >= 10 ? '#16a34a' : '#dc2626';
        }
        
        if (mediaFinalCell) {
            mediaFinalCell.textContent = mediaFinal.toFixed(1);
            mediaFinalCell.style.color = mediaFinal >= 10 ? '#16a34a' : '#dc2626';
        }
        
        let totalAulas = 54;
        let percentagemFaltas = Math.min(100, Math.round((faltas / totalAulas) * 100));
        let progressBar = row.querySelector('.faltas-progress');
        let percentSpan = row.querySelector('.faltas-percent');
        
        if (progressBar) {
            progressBar.style.width = percentagemFaltas + '%';
            if (percentagemFaltas > 50) {
                progressBar.style.backgroundColor = '#dc2626';
            } else if (percentagemFaltas > 25) {
                progressBar.style.backgroundColor = '#eab308';
            } else {
                progressBar.style.backgroundColor = '#22c55e';
            }
        }
        if (percentSpan) {
            percentSpan.innerHTML = percentagemFaltas + '%' + 
                (percentagemFaltas >= 50 ? ' <i class="fas fa-exclamation-triangle text-danger"></i>' : 
                 (percentagemFaltas >= 25 ? ' <i class="fas fa-clock text-warning"></i>' : ''));
        }
        
        let situacaoCell = row.querySelector('.situacao-cell');
        if (situacaoCell) {
            situacaoCell.innerHTML = getSituacaoHtml(situacao);
        }
        
        marcarAlteracoesPendentes();
    }
    
    // ==================== AUTO-SAVE ====================
    
    let autoSaveTimer;
    let alteracoesPendentes = false;
    let form = document.getElementById('formNotas');
    
    function marcarAlteracoesPendentes() {
        alteracoesPendentes = true;
        let statusSpan = document.getElementById('saveStatusText');
        if (statusSpan) {
            statusSpan.innerHTML = '<i class="fas fa-exclamation-triangle text-warning"></i> Não salvo';
            statusSpan.classList.add('text-warning');
        }
        
        if (autoSaveTimer) clearTimeout(autoSaveTimer);
        autoSaveTimer = setTimeout(function() {
            if (alteracoesPendentes) {
                salvarAutomaticamente();
            }
        }, 3000);
    }
    
    function salvarAutomaticamente() {
        if (!form || !alteracoesPendentes) return;
        
        let formData = new FormData(form);
        let spinner = document.getElementById('saveSpinner');
        let statusSpan = document.getElementById('saveStatusText');
        
        if (spinner) spinner.classList.remove('d-none');
        if (statusSpan) statusSpan.innerHTML = 'Salvando...';
        
        fetch('{{ route("professor.notas.salvar.ajax") }}', {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alteracoesPendentes = false;
                let agora = new Date();
                let horaStr = agora.toLocaleTimeString('pt-PT');
                if (statusSpan) {
                    statusSpan.innerHTML = `<i class="fas fa-check-circle text-success"></i> Salvo às ${horaStr}`;
                    statusSpan.classList.remove('text-warning');
                }
            } else {
                throw new Error(data.message);
            }
        })
        .catch(error => {
            console.error('Auto-save error:', error);
            if (statusSpan) {
                statusSpan.innerHTML = '<i class="fas fa-exclamation-circle text-danger"></i> Erro ao salvar';
            }
        })
        .finally(() => {
            if (spinner) spinner.classList.add('d-none');
        });
    }
    
    // ==================== EVENT LISTENERS ====================
    
    document.querySelectorAll('.nota-input, .exame-input, .faltas-input').forEach(input => {
        input.addEventListener('input', function() {
            let row = this.closest('.aluno-row');
            if (row) atualizarLinha(row);
        });
        
        input.addEventListener('blur', function() {
            let val = parseFloat(this.value);
            let min = parseFloat(this.min) || 0;
            let max = parseFloat(this.max) || 20;
            if (!isNaN(val)) {
                if (val < min) this.value = min;
                if (val > max) this.value = max;
                if (this.step === '0.5') {
                    this.value = Math.round(val * 2) / 2;
                }
            }
            let row = this.closest('.aluno-row');
            if (row) atualizarLinha(row);
        });
    });
    
    let btnRecalcular = document.getElementById('btnRecalcular');
    if (btnRecalcular) {
        btnRecalcular.addEventListener('click', function() {
            document.querySelectorAll('.aluno-row').forEach(row => atualizarLinha(row));
            toast('Médias recalculadas!', 'success');
        });
    }
    
    let btnZeros = document.getElementById('btnPreencherZeros');
    if (btnZeros) {
        btnZeros.addEventListener('click', function() {
            if (confirm('Preencher todas as notas vazias com 0?')) {
                document.querySelectorAll('.mac-input, .prova-input').forEach(input => {
                    if (input.value === '') {
                        input.value = 0;
                        let row = input.closest('.aluno-row');
                        if (row) atualizarLinha(row);
                    }
                });
                toast('Notas vazias preenchidas com 0!', 'info');
            }
        });
    }
    
    if (form) {
        form.addEventListener('submit', function(e) {
            let btn = document.getElementById('btnSalvar');
            if (btn) {
                btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Salvando...';
                btn.disabled = true;
            }
        });
    }
    
    function toast(message, type = 'info') {
        let toastDiv = document.createElement('div');
        toastDiv.className = `toast-notification toast-${type}`;
        toastDiv.innerHTML = `<i class="fas ${type === 'success' ? 'fa-check-circle' : 'fa-info-circle'} me-2"></i>${message}`;
        document.body.appendChild(toastDiv);
        setTimeout(() => toastDiv.remove(), 3000);
    }
    
    document.querySelectorAll('.aluno-row').forEach(row => atualizarLinha(row));
});
</script>
@endpush

@push('styles')
<style>
.table-card {
    background: white;
    border-radius: 16px;
    padding: 1.5rem;
    box-shadow: 0 1px 3px rgba(0,0,0,0.08);
    margin-bottom: 1.5rem;
}

.btn-sm-custom {
    background: #1e3a8a;
    color: white;
    border: none;
    border-radius: 8px;
    padding: 0.5rem 1.25rem;
    font-size: 0.875rem;
    font-weight: 500;
    transition: all 0.2s;
}

.btn-sm-custom:hover {
    background: #1e40af;
    transform: translateY(-1px);
}

.btn-sm-outline {
    background: white;
    color: #1e3a8a;
    border: 1px solid #1e3a8a;
    border-radius: 8px;
    padding: 0.5rem 1.25rem;
    font-size: 0.875rem;
    font-weight: 500;
    transition: all 0.2s;
}

.btn-sm-outline:hover {
    background: #f0f4ff;
}

.btn-back {
    background: #f1f5f9;
    color: #475569;
    padding: 0.5rem 1rem;
    border-radius: 8px;
    text-decoration: none;
    font-size: 0.875rem;
    transition: all 0.2s;
}

.btn-back:hover {
    background: #e2e8f0;
    color: #1e293b;
}

.table th {
    background: #f8fafc;
    font-weight: 600;
    font-size: 0.8rem;
    border-bottom: 1px solid #e5e7eb;
    vertical-align: middle;
}

.table td {
    vertical-align: middle;
    border-bottom: 1px solid #e5e7eb;
}

.form-control-sm {
    font-size: 0.9rem;
    padding: 0.375rem 0.5rem;
}

.form-control-sm:focus {
    border-color: #1e3a8a;
    box-shadow: 0 0 0 0.2rem rgba(30, 58, 138, 0.25);
}

.avatar-circle {
    width: 36px;
    height: 36px;
    background: #e0e7ff;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 10px;
}

.avatar-text {
    color: #1e3a8a;
    font-weight: 600;
    font-size: 1rem;
}

.toast-notification {
    position: fixed;
    bottom: 20px;
    right: 20px;
    background: white;
    padding: 12px 20px;
    border-radius: 8px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    z-index: 9999;
    animation: slideIn 0.3s ease;
}

.toast-success {
    border-left: 4px solid #22c55e;
    color: #166534;
}

.toast-info {
    border-left: 4px solid #3b82f6;
    color: #1e40af;
}

.progress {
    background-color: #e2e8f0;
    border-radius: 10px;
}

@media (max-width: 768px) {
    .table-card {
        padding: 1rem;
    }
    
    .btn-sm-custom, .btn-sm-outline {
        padding: 0.35rem 0.8rem;
        font-size: 0.75rem;
    }
    
    .btn-group .btn {
        font-size: 0.7rem;
        padding: 4px 8px;
    }
}

@keyframes slideIn {
    from {
        transform: translateX(100%);
        opacity: 0;
    }
    to {
        transform: translateX(0);
        opacity: 1;
    }
}
</style>
@endpush