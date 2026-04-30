

<?php $__env->startSection('content'); ?>
<div class="container-fluid px-4">
    
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
        <div>
            <h4 class="mb-1" style="color: #1e3a8a;">
                <i class="fas fa-chart-line me-2"></i> Minhas Notas
            </h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="<?php echo e(route('aluno.dashboard')); ?>">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="#">Boletim</a></li>
                    <li class="breadcrumb-item active">Notas</li>
                </ol>
            </nav>
        </div>
        <div>
            <span class="badge bg-primary p-2">
                <i class="fas fa-calendar-alt me-1"></i> Ano Letivo: <?php echo e($anoLectivo ?? date('Y')); ?>

            </span>
        </div>
    </div>

    
    <div class="card mb-4">
        <div class="card-body py-3">
            <div class="d-flex justify-content-center gap-2">
                <div class="btn-group" role="group">
                    <a href="<?php echo e(route('aluno.notas', ['trimestre' => 1])); ?>" 
                       class="btn btn-sm <?php echo e(($trimestre ?? 1) == 1 ? 'btn-primary' : 'btn-outline-primary'); ?>">
                        <i class="fas fa-calendar-week me-1"></i> 1º Trimestre
                    </a>
                    <a href="<?php echo e(route('aluno.notas', ['trimestre' => 2])); ?>" 
                       class="btn btn-sm <?php echo e(($trimestre ?? 1) == 2 ? 'btn-primary' : 'btn-outline-primary'); ?>">
                        <i class="fas fa-calendar-week me-1"></i> 2º Trimestre
                    </a>
                    <a href="<?php echo e(route('aluno.notas', ['trimestre' => 3])); ?>" 
                       class="btn btn-sm <?php echo e(($trimestre ?? 1) == 3 ? 'btn-primary' : 'btn-outline-primary'); ?>">
                        <i class="fas fa-calendar-week me-1"></i> 3º Trimestre
                    </a>
                </div>
            </div>
        </div>
    </div>

    
    <div class="card">
        <div class="card-header bg-white">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <i class="fas fa-edit me-2 text-primary"></i>
                    <strong>Boletim de Notas</strong>
                    <span class="badge bg-light text-dark ms-2">
                        <?php echo e($trimestre ?? 1); ?>º Trimestre
                    </span>
                </div>
                <div>
                    <span class="badge bg-secondary">
                        <i class="fas fa-school me-1"></i> 
                        Turma: <?php echo e($turma->nome ?? 'A aguardar atribuição'); ?>

                    </span>
                </div>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th style="min-width: 160px">DISCIPLINA</th>
                            <th class="text-center" style="min-width: 70px">MAC</th>
                            <th class="text-center" style="min-width: 70px">PROVA</th>
                            <th class="text-center" style="min-width: 90px">MÉDIA TRIM.</th>
                            <th class="text-center" style="min-width: 70px">EXAME</th>
                            <th class="text-center" style="min-width: 90px">MÉDIA FINAL</th>
                            <th class="text-center" style="min-width: 90px">FALTAS</th>
                            <th class="text-center" style="min-width: 110px">SITUAÇÃO</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $disciplinas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $disciplina): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                        <?php
                            // Buscar a nota desta disciplina para o trimestre selecionado
                            $nota = $notas->firstWhere('disciplina_id', $disciplina->id);
                            
                            $mac = $nota->avaliacao_continua ?? null;
                            $prova = $nota->prova_trimestral ?? null;
                            $mediaTrimestral = $nota->media_trimestral ?? null;
                            $exame = $nota->exame_final ?? null;
                            $mediaFinal = $nota->media_final ?? null;
                            $faltas = $nota->faltas ?? 0;
                            $situacao = $nota->situacao ?? 'cursando';
                            
                            $percentFaltas = 54 > 0 ? min(100, round(($faltas / 54) * 100)) : 0;
                            
                            $mediaFinalValue = $mediaFinal ?? $mediaTrimestral ?? 0;
                            
                            $situacaoClass = match($situacao) {
                                'aprovado', 'aprovado_exame' => 'success',
                                'exame' => 'warning',
                                'reprovado' => 'danger',
                                default => 'secondary'
                            };
                            $situacaoText = match($situacao) {
                                'aprovado' => 'Aprovado',
                                'aprovado_exame' => 'Aprovado (Exame)',
                                'exame' => 'Em Exame',
                                'reprovado' => 'Reprovado',
                                default => 'Cursando'
                            };
                            $situacaoIcon = match($situacao) {
                                'aprovado', 'aprovado_exame' => 'fa-check-circle',
                                'exame' => 'fa-exclamation-triangle',
                                'reprovado' => 'fa-times-circle',
                                default => 'fa-clock'
                            };
                            
                            $temNota = $nota !== null;
                        ?>
                        <tr class="<?php echo e(!$temNota ? 'table-light' : ''); ?>">
                            <td>
                                <strong><?php echo e($disciplina->nome); ?></strong>
                                <br>
                                <small class="text-muted"><?php echo e($disciplina->codigo ?? ''); ?></small>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!$temNota): ?>
                                    <br>
                                    <span class="badge bg-secondary">Sem notas lançadas</span>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </td>
                            <td class="text-center">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($temNota): ?>
                                    <span class="fw-bold"><?php echo e(number_format($mac ?? 0, 1)); ?></span>
                                <?php else: ?>
                                    <span class="text-muted">—</span>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </td>
                            <td class="text-center">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($temNota): ?>
                                    <span class="fw-bold"><?php echo e(number_format($prova ?? 0, 1)); ?></span>
                                <?php else: ?>
                                    <span class="text-muted">—</span>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </td>
                            <td class="text-center">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($temNota && $mediaTrimestral !== null): ?>
                                    <span class="badge bg-light text-dark">
                                        <?php echo e(number_format($mediaTrimestral, 1)); ?>

                                    </span>
                                <?php else: ?>
                                    <span class="text-muted">—</span>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </td>
                            <td class="text-center">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($temNota && $exame): ?>
                                    <span class="badge bg-warning text-dark">
                                        <?php echo e(number_format($exame, 1)); ?>

                                    </span>
                                <?php else: ?>
                                    <span class="text-muted">—</span>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </td>
                            <td class="text-center">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($temNota): ?>
                                    <strong class="text-<?php echo e($mediaFinalValue >= 10 ? 'success' : 'danger'); ?>">
                                        <?php echo e(number_format($mediaFinalValue, 1)); ?>

                                    </strong>
                                <?php else: ?>
                                    <span class="text-muted">—</span>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </td>
                            <td class="text-center">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($temNota): ?>
                                    <div class="d-flex flex-column align-items-center">
                                        <span class="fw-bold"><?php echo e($faltas); ?></span>
                                        <div class="progress w-100" style="height: 4px;">
                                            <div class="progress-bar bg-<?php echo e($percentFaltas > 50 ? 'danger' : ($percentFaltas > 25 ? 'warning' : 'success')); ?>" 
                                                 style="width: <?php echo e($percentFaltas); ?>%">
                                            </div>
                                        </div>
                                        <small class="text-muted"><?php echo e($percentFaltas); ?>%</small>
                                    </div>
                                <?php else: ?>
                                    <span class="text-muted">—</span>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </td>
                            <td class="text-center">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($temNota): ?>
                                    <span class="badge bg-<?php echo e($situacaoClass); ?> px-3 py-2">
                                        <i class="fas <?php echo e($situacaoIcon); ?> me-1"></i>
                                        <?php echo e($situacaoText); ?>

                                    </span>
                                <?php else: ?>
                                    <span class="badge bg-secondary px-3 py-2">
                                        <i class="fas fa-clock me-1"></i>
                                        Pendente
                                    </span>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </td>
                        </tr>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                        <tr>
                            <td colspan="8" class="text-center py-5">
                                <i class="fas fa-book-open fa-4x text-muted mb-3 d-block"></i>
                                <h5 class="text-muted">Nenhuma disciplina associada à sua turma</h5>
                                <p class="text-muted small">As disciplinas serão exibidas quando forem associadas à sua turma.</p>
                            </td>
                        </tr>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </tbody>
                    <tfoot class="table-light">
                        <tr>
                            <td colspan="8" class="text-end py-2">
                                <small class="text-muted">
                                    <i class="fas fa-info-circle me-1"></i>
                                    Média para aprovação: 10 valores | <i class="fas fa-clock ms-2 me-1"></i>Disciplinas sem notas aguardam lançamento
                                </small>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

    
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(isset($notas) && $notas->count() > 0): ?>
    <div class="row mt-4 g-3">
        <div class="col-md-3 col-sm-6">
            <div class="card summary-card border-top-success">
                <div class="card-body py-3">
                    <div class="row align-items-center">
                        <div class="col-4">
                            <i class="fas fa-check-circle fa-2x text-success"></i>
                        </div>
                        <div class="col-8 text-end">
                            <h3 class="mb-0 fw-bold text-success"><?php echo e($notas->where('situacao', 'aprovado')->count() + $notas->where('situacao', 'aprovado_exame')->count()); ?></h3>
                            <small class="text-muted">APROVADAS</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="card summary-card border-top-warning">
                <div class="card-body py-3">
                    <div class="row align-items-center">
                        <div class="col-4">
                            <i class="fas fa-exclamation-triangle fa-2x text-warning"></i>
                        </div>
                        <div class="col-8 text-end">
                            <h3 class="mb-0 fw-bold text-warning"><?php echo e($notas->where('situacao', 'exame')->count()); ?></h3>
                            <small class="text-muted">EM EXAME</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="card summary-card border-top-danger">
                <div class="card-body py-3">
                    <div class="row align-items-center">
                        <div class="col-4">
                            <i class="fas fa-times-circle fa-2x text-danger"></i>
                        </div>
                        <div class="col-8 text-end">
                            <h3 class="mb-0 fw-bold text-danger"><?php echo e($notas->where('situacao', 'reprovado')->count()); ?></h3>
                            <small class="text-muted">REPROVADAS</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="card summary-card border-top-primary">
                <div class="card-body py-3">
                    <div class="row align-items-center">
                        <div class="col-4">
                            <i class="fas fa-chart-line fa-2x text-primary"></i>
                        </div>
                        <div class="col-8 text-end">
                            <h3 class="mb-0 fw-bold text-primary"><?php echo e(number_format($notas->avg('media_final') ?? $notas->avg('media_trimestral') ?? 0, 1)); ?></h3>
                            <small class="text-muted">MÉDIA GERAL</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>
<style>
    .card {
        border: none;
        border-radius: 16px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.08);
        background: white;
    }
    
    .card-header {
        background: white;
        border-bottom: 1px solid #eef2f6;
        border-radius: 16px 16px 0 0 !important;
        padding: 1rem 1.25rem;
    }
    
    .table-hover tbody tr:hover {
        background-color: #f8fafc;
    }
    
    .table th {
        font-size: 0.7rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: #64748b;
        font-weight: 600;
        border-bottom: 1px solid #eef2f6;
    }
    
    .table td {
        vertical-align: middle;
        font-size: 0.85rem;
        border-bottom: 1px solid #eef2f6;
    }
    
    .badge {
        font-weight: 500;
        border-radius: 8px;
    }
    
    .progress {
        border-radius: 10px;
        background-color: #e2e8f0;
    }
    
    .summary-card {
        border: none;
        border-radius: 16px;
        transition: all 0.2s ease;
        background: white;
        box-shadow: 0 1px 3px rgba(0,0,0,0.08);
    }
    
    .summary-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }
    
    .border-top-success { border-top: 3px solid #22c55e !important; }
    .border-top-warning { border-top: 3px solid #f59e0b !important; }
    .border-top-danger { border-top: 3px solid #ef4444 !important; }
    .border-top-primary { border-top: 3px solid #1e3a8a !important; }
    
    @media (max-width: 768px) {
        .table th, .table td {
            font-size: 0.7rem;
            padding: 0.5rem;
        }
        
        .summary-card h3 {
            font-size: 1.3rem;
        }
        
        .summary-card small {
            font-size: 0.6rem;
        }
        
        .btn-group .btn {
            font-size: 0.7rem;
            padding: 0.25rem 0.5rem;
        }
    }
    
    @media print {
        .btn-group, .summary-card {
            display: none;
        }
        
        .card {
            box-shadow: none;
            border: 1px solid #ddd;
        }
    }
</style>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.aluno', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\colegio-genesis-oficial\resources\views/aluno/notas.blade.php ENDPATH**/ ?>