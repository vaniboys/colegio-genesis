

<?php $__env->startSection('content'); ?>
<div class="table-card">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="mb-0" style="color: #1e3a8a;">
            <i class="fas fa-tasks me-2"></i> Avaliações - <?php echo e($turma->nome); ?>

        </h5>
        <a href="<?php echo e(route('professor.avaliacao.criar', $turma->id)); ?>" class="btn-sm-custom">
            <i class="fas fa-plus"></i> Nova Avaliação
        </a>
    </div>
    
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($avaliacoes->count() > 0): ?>
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Título</th>
                        <th>Tipo</th>
                        <th>Arquivo</th>
                        <th>Data Entrega</th>
                        <th>Pontuação</th>
                        <th>Status</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $avaliacoes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $avaliacao): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                    <tr>
                        <td><?php echo e($avaliacao->titulo); ?></td>
                        <td>
                            <span class="badge bg-<?php echo e($avaliacao->tipo == 'quiz' ? 'primary' : ($avaliacao->tipo == 'prova' ? 'warning' : 'info')); ?>">
                                <?php echo e(ucfirst($avaliacao->tipo)); ?>

                            </span>
                        </td>
                        <td>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($avaliacao->arquivo): ?>
                                <a href="<?php echo e(Storage::url($avaliacao->arquivo)); ?>" class="btn-sm-custom" style="background: #10b981;" target="_blank">
                                    <i class="fas fa-download"></i> Baixar
                                </a>
                            <?php else: ?>
                                <span class="text-muted">-</span>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </td>
                        <td><?php echo e(date('d/m/Y', strtotime($avaliacao->data_entrega))); ?></td>
                        <td><?php echo e($avaliacao->pontuacao_maxima); ?> pts</td>
                        <td>
                            <span class="badge bg-<?php echo e($avaliacao->publicado ? 'success' : 'secondary'); ?>">
                                <?php echo e($avaliacao->publicado ? 'Publicado' : 'Rascunho'); ?>

                            </span>
                        </td>
                        <td>
                            <a href="<?php echo e(route('professor.questoes', $avaliacao->id)); ?>" class="btn-sm-custom" style="background: #f59e0b;">
                                <i class="fas fa-question-circle"></i> Questões
                            </a>
                            <a href="<?php echo e(route('professor.avaliacao.editar', $avaliacao->id)); ?>" class="btn-sm-custom">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="<?php echo e(route('professor.avaliacao.deletar', $avaliacao->id)); ?>" method="POST" class="d-inline">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button type="submit" class="btn-sm-custom" style="background: #dc2626;" onclick="return confirm('Deletar esta avaliação?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <div class="alert alert-info">
            <i class="fas fa-info-circle"></i> Nenhuma avaliação criada.
        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.professor', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\colegio-genesis-oficial\resources\views/professor/avaliacoes.blade.php ENDPATH**/ ?>