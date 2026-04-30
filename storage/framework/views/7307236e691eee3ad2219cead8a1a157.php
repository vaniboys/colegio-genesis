

<?php $__env->startSection('content'); ?>
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <div>
            <i class="fas fa-file-alt me-2"></i> 
            <strong>Boletim Escolar - <?php echo e(date('Y')); ?></strong>
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
            <img src="<?php echo e(asset('images/logo.png')); ?>" alt="Logo" style="height: 80px;" onerror="this.style.display='none'">
            <h3 class="mt-2">Colégio Gênesis</h3>
            <p class="text-muted">Sistema de Gestão Escolar - Angola</p>
            <hr>
            <h5>Boletim de Notas - <?php echo e(date('Y')); ?></h5>
            <p><strong>Aluno:</strong> <?php echo e($aluno->nome_completo); ?> | 
               <strong>Processo:</strong> <?php echo e($aluno->processo); ?> |
               <strong>Turma:</strong> <?php echo e($matricula->turma->nome ?? 'N/A'); ?></p>
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
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $notas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $nota): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                    <tr>
                        <td><strong><?php echo e($nota->disciplina->nome); ?></strong></td>
                        
                        <td class="text-center"><?php echo e(number_format($nota->avaliacao_continua ?? 0, 1)); ?></td>
                        <td class="text-center"><?php echo e(number_format($nota->prova_trimestral ?? 0, 1)); ?></td>
                        <td class="text-center"><?php echo e(number_format($nota->media_trimestral ?? 0, 1)); ?></td>
                        <td class="text-center"><?php echo e($nota->exame_final ? number_format($nota->exame_final, 1) : '-'); ?></td>
                        <td class="text-center">
                            <strong class="<?php echo e(($nota->media_final ?? $nota->media_trimestral ?? 0) >= 10 ? 'text-success' : 'text-danger'); ?>">
                                <?php echo e(number_format($nota->media_final ?? $nota->media_trimestral ?? 0, 1)); ?>

                            </strong>
                        </td>
                        <td class="text-center">
                            
                            <span class="badge bg-<?php echo e(($nota->situacao == 'aprovado') ? 'success' : (($nota->situacao == 'exame') ? 'warning' : 'danger')); ?>">
                                <?php echo e($nota->situacao ?? 'Cursando'); ?>

                            </span>
                        </td>
                    </tr>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    <tr>
                        <td colspan="7" class="text-center text-muted">Nenhuma nota disponível</td>
                    </tr>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </tbody>
                <tfoot class="table-light">
                    <tr>
                        <th colspan="5" class="text-end">Média Geral:</th>
                        <th class="text-center">
                            <strong class="text-<?php echo e($mediaGeral >= 10 ? 'success' : 'danger'); ?>">
                                <?php echo e(number_format($mediaGeral ?? 0, 1)); ?>

                            </strong>
                        </th>
                        <th class="text-center">
                            <span class="badge bg-<?php echo e($mediaGeral >= 10 ? 'success' : 'danger'); ?>">
                                <?php echo e($mediaGeral >= 10 ? 'Aprovado' : 'Recuperação'); ?>

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
                        <p><strong>Melhor Nota:</strong> <?php echo e(number_format($melhorNota ?? 0, 1)); ?></p>
                        <p><strong>Pior Nota:</strong> <?php echo e(number_format($piorNota ?? 0, 1)); ?></p>
                        <p><strong>Total de Faltas:</strong> <?php echo e($totalFaltas ?? 0); ?></p>
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
                Emitido em: <?php echo e(date('d/m/Y H:i:s')); ?>

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
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.aluno', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\colegio-genesis-oficial\resources\views/aluno/boletim.blade.php ENDPATH**/ ?>