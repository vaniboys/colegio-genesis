

<?php $__env->startSection('content'); ?>
<div class="container-fluid px-4">
    
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
        <div>
            <h4 class="mb-1" style="color: #1e3a8a;">
                <i class="fas fa-history me-2"></i> Histórico Escolar
            </h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="<?php echo e(route('aluno.dashboard')); ?>">Dashboard</a></li>
                    <li class="breadcrumb-item active">Histórico Escolar</li>
                </ol>
            </nav>
        </div>
        <div>
            <span class="badge bg-primary p-2">
                <i class="fas fa-user-graduate me-1"></i> Aluno: <?php echo e($aluno->nome_completo); ?>

            </span>
        </div>
    </div>

    
    <div class="row g-3 mb-4">
        <div class="col-md-3 col-sm-6">
            <div class="card summary-card border-top-primary">
                <div class="card-body py-3">
                    <div class="row align-items-center">
                        <div class="col-4">
                            <i class="fas fa-calendar-alt fa-2x text-primary"></i>
                        </div>
                        <div class="col-8 text-end">
                            <h3 class="mb-0 fw-bold text-primary"><?php echo e(count($historico)); ?></h3>
                            <small class="text-muted">ANOS LECTIVOS</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="card summary-card border-top-success">
                <div class="card-body py-3">
                    <div class="row align-items-center">
                        <div class="col-4">
                            <i class="fas fa-check-circle fa-2x text-success"></i>
                        </div>
                        <div class="col-8 text-end">
                            <h3 class="mb-0 fw-bold text-success"><?php echo e($totalAprovacoes); ?></h3>
                            <small class="text-muted">DISCIPLINAS APROVADAS</small>
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
                            <h3 class="mb-0 fw-bold text-danger"><?php echo e($totalReprovacoes); ?></h3>
                            <small class="text-muted">DISCIPLINAS REPROVADAS</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="card summary-card border-top-info">
                <div class="card-body py-3">
                    <div class="row align-items-center">
                        <div class="col-4">
                            <i class="fas fa-chart-line fa-2x text-info"></i>
                        </div>
                        <div class="col-8 text-end">
                            <h3 class="mb-0 fw-bold text-info"><?php echo e($mediaGeralHistorico); ?></h3>
                            <small class="text-muted">MÉDIA GERAL</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    
    <div class="card mb-4">
        <div class="card-header bg-white">
            <i class="fas fa-chart-pie me-2 text-primary"></i>
            <strong>Progresso Académico</strong>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-8">
                    <div class="mb-3">
                        <div class="d-flex justify-content-between mb-1">
                            <small>Taxa de Aprovação</small>
                            <small><?php echo e($percentagemAprovacao); ?>%</small>
                        </div>
                        <div class="progress" style="height: 10px;">
                            <div class="progress-bar bg-success" style="width: <?php echo e($percentagemAprovacao); ?>%"></div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="d-flex justify-content-between mb-1">
                            <small>Taxa de Reprovação</small>
                            <small><?php echo e($percentagemReprovacao); ?>%</small>
                        </div>
                        <div class="progress" style="height: 10px;">
                            <div class="progress-bar bg-danger" style="width: <?php echo e($percentagemReprovacao); ?>%"></div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 text-center">
                    <div class="border rounded p-3 bg-light">
                        <i class="fas fa-graduation-cap fa-3x text-primary mb-2"></i>
                        <h5 class="mb-0"><?php echo e($totalDisciplinas); ?></h5>
                        <small class="text-muted">Total de Disciplinas Cursadas</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $historico; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ano): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
    <div class="card mb-4">
        <div class="card-header bg-white">
            <div class="d-flex justify-content-between align-items-center flex-wrap">
                <div>
                    <i class="fas fa-calendar-alt me-2 text-primary"></i>
                    <strong>Ano Lectivo: <?php echo e($ano['ano_lectivo']); ?></strong>
                    <span class="badge bg-secondary ms-2"><?php echo e($ano['turma']->nome ?? 'Turma não definida'); ?></span>
                </div>
                <div>
                    <span class="badge bg-<?php echo e($ano['situacao'] == 'aprovado' ? 'success' : ($ano['situacao'] == 'exame' ? 'warning' : 'danger')); ?> fs-6">
                        <i class="fas fa-<?php echo e($ano['situacao'] == 'aprovado' ? 'check-circle' : ($ano['situacao'] == 'exame' ? 'exclamation-triangle' : 'times-circle')); ?> me-1"></i>
                        <?php echo e(ucfirst($ano['situacao'])); ?>

                    </span>
                </div>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Disciplina</th>
                            <th class="text-center">1º Trim</th>
                            <th class="text-center">2º Trim</th>
                            <th class="text-center">3º Trim</th>
                            <th class="text-center">Média Final</th>
                            <th class="text-center">Faltas</th>
                            <th class="text-center">Situação</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $ano['disciplinas']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $disciplina): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                        <?php
                            $nota1 = $disciplina['notas_trimestres']['1'];
                            $nota2 = $disciplina['notas_trimestres']['2'];
                            $nota3 = $disciplina['notas_trimestres']['3'];
                            
                            $situacaoClass = match($disciplina['situacao']) {
                                'aprovado' => 'success',
                                'exame' => 'warning',
                                default => 'danger'
                            };
                            $situacaoIcon = match($disciplina['situacao']) {
                                'aprovado' => 'fa-check-circle',
                                'exame' => 'fa-exclamation-triangle',
                                default => 'fa-times-circle'
                            };
                        ?>
                        <tr>
                            <td>
                                <strong><?php echo e($disciplina['disciplina']->nome); ?></strong>
                                <br>
                                <small class="text-muted"><?php echo e($disciplina['disciplina']->codigo); ?></small>
                            </td>
                            <td class="text-center">
                                <?php echo e(number_format($nota1->media_trimestral ?? 0, 1)); ?>

                            </td>
                            <td class="text-center">
                                <?php echo e(number_format($nota2->media_trimestral ?? 0, 1)); ?>

                             </td>
                            <td class="text-center">
                                <?php echo e(number_format($nota3->media_trimestral ?? 0, 1)); ?>

                             </td>
                            <td class="text-center">
                                <strong class="text-<?php echo e($disciplina['media_final'] >= 10 ? 'success' : 'danger'); ?>">
                                    <?php echo e(number_format($disciplina['media_final'], 1)); ?>

                                </strong>
                             </td>
                            <td class="text-center"><?php echo e($disciplina['total_faltas']); ?></td>
                            <td class="text-center">
                                <span class="badge bg-<?php echo e($situacaoClass); ?>">
                                    <i class="fas <?php echo e($situacaoIcon); ?> me-1"></i>
                                    <?php echo e(ucfirst($disciplina['situacao'])); ?>

                                </span>
                             </td>
                        </tr>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    </tbody>
                    <tfoot class="table-light">
                        <tr>
                            <td colspan="6" class="text-end">
                                <strong>Média Geral do Ano: <?php echo e($ano['media_geral']); ?></strong>
                             </td>
                            <td class="text-center">
                                <span class="badge bg-<?php echo e($ano['situacao'] == 'aprovado' ? 'success' : ($ano['situacao'] == 'exame' ? 'warning' : 'danger')); ?>">
                                    <?php echo e(ucfirst($ano['situacao'])); ?>

                                </span>
                             </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
    <div class="card">
        <div class="card-body text-center py-5">
            <i class="fas fa-history fa-4x text-muted mb-3 d-block"></i>
            <h5 class="text-muted">Nenhum registo encontrado</h5>
            <p class="text-muted small">O aluno ainda não possui histórico escolar.</p>
        </div>
    </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(count($historico) > 0): ?>
    <div class="fixed-bottom mb-3 me-3 text-end">
        <button onclick="window.print()" class="btn btn-primary rounded-circle shadow" style="width: 50px; height: 50px;">
            <i class="fas fa-print"></i>
        </button>
    </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>
<style>
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
    
    .border-top-primary { border-top: 3px solid #1e3a8a !important; }
    .border-top-success { border-top: 3px solid #22c55e !important; }
    .border-top-danger { border-top: 3px solid #ef4444 !important; }
    .border-top-info { border-top: 3px solid #3b82f6 !important; }
    
    @media print {
        .navbar, .sidebar, .topbar, .btn-print-float, .fixed-bottom, .btn-group, .btn, .card-header .badge:last-child {
            display: none !important;
        }
        
        .sidebar, .main-content {
            margin-left: 0 !important;
            padding: 0 !important;
        }
        
        .card {
            box-shadow: none !important;
            border: 1px solid #ddd !important;
            break-inside: avoid;
        }
        
        .summary-card {
            box-shadow: none !important;
            border: 1px solid #ddd !important;
        }
        
        body {
            background: white !important;
            padding: 0 !important;
            margin: 0 !important;
        }
        
        .container-fluid {
            padding: 0 !important;
        }
    }
</style>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.aluno', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\colegio-genesis-oficial\resources\views/aluno/historico.blade.php ENDPATH**/ ?>