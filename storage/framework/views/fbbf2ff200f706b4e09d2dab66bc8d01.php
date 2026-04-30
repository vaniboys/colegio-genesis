

<?php $__env->startSection('content'); ?>
<div class="table-card">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h6 class="mb-0" style="color: #1e3a8a;">
            <i class="fas fa-chalkboard-user me-2"></i> Minhas Turmas
        </h6>
    </div>
    
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($turmas->count() > 0): ?>
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Turma</th>
                        <th>Classe</th>
                        <th>Turno</th>
                        <th>Alunos</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $turmas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $turma): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                    <tr>
                        <td><strong><?php echo e($turma->nome); ?></strong></td>
                        <td><?php echo e($turma->classe->nome ?? 'N/A'); ?></td>  
                        <td>
                            <span class="badge-<?php echo e($turma->turno == 'manha' ? 'manha' : 'tarde'); ?>">
                                <?php echo e(ucfirst($turma->turno)); ?>

                            </span>
                        </td>
                        <td><?php echo e($turma->alunos()->count()); ?></td>
                        <td>
                            <div class="d-flex gap-1 flex-wrap">
                                <a href="<?php echo e(route('professor.notas', $turma->id)); ?>" class="btn-sm-custom">
                                    <i class="fas fa-edit"></i> Notas
                                </a>
                                <a href="<?php echo e(route('professor.materiais', $turma->id)); ?>" class="btn-sm-custom" style="background: #f59e0b;">
                                    <i class="fas fa-folder-open"></i> Materiais
                                </a>
                                <a href="<?php echo e(route('professor.avaliacoes', $turma->id)); ?>" class="btn-sm-custom" style="background: #10b981;">
                                    <i class="fas fa-tasks"></i> Avaliações
                                </a>
                                <a href="<?php echo e(route('professor.tarefas', $turma->id)); ?>" class="btn-sm-custom" style="background: #8b5cf6;">
                                    <i class="fas fa-file-alt"></i> Tarefas
                                </a>
                                <a href="<?php echo e(route('professor.turma.alunos', $turma->id)); ?>" class="btn-sm-custom" style="background: #8b5cf6;">
                                    <i class="fas fa-users"></i> Ver Alunos
                                </a>
                            </div>
                        </td>
                    </tr>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <div class="alert alert-info py-2">
            <i class="fas fa-info-circle"></i> Nenhuma turma atribuída.
        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.professor', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\colegio-genesis-oficial\resources\views/professor/turmas.blade.php ENDPATH**/ ?>