

<?php $__env->startSection('content'); ?>
<div class="row g-3 mb-4">
    <div class="col-md-3 col-sm-6">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="stat-value"><?php echo e($turmas->count()); ?></div>
                    <div class="stat-label">Minhas Turmas</div>
                </div>
                <div class="stat-icon" style="background: #e0e7ff; color: #1e3a8a;">
                    <i class="fas fa-chalkboard-user"></i>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 col-sm-6">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="stat-value"><?php echo e($totalAlunos); ?></div>
                    <div class="stat-label">Total de Alunos</div>
                </div>
                <div class="stat-icon" style="background: #dbeafe; color: #3b82f6;">
                    <i class="fas fa-users"></i>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 col-sm-6">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="stat-value">0</div>
                    <div class="stat-label">Notas Pendentes</div>
                </div>
                <div class="stat-icon" style="background: #fef3c7; color: #d97706;">
                    <i class="fas fa-clock"></i>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 col-sm-6">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="stat-value">0</div>
                    <div class="stat-label">Aulas Hoje</div>
                </div>
                <div class="stat-icon" style="background: #dcfce7; color: #16a34a;">
                    <i class="fas fa-calendar-day"></i>
                </div>
            </div>
        </div>
    </div>
</div>

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
                        <td>
                            <strong><?php echo e($turma->nome); ?></strong>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($turma->curso): ?>
                                <br>
                                <small class="text-muted"><?php echo e($turma->curso->nome); ?></small>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </td>
                        <td class="align-middle">
                            <?php echo e($turma->classe->nome ?? $turma->classe_nome ?? 'N/A'); ?>

                        </td>
                        <td class="align-middle">
                            <span class="badge-<?php echo e($turma->turno == 'manha' ? 'manha' : ($turma->turno == 'tarde' ? 'tarde' : 'noite')); ?>">
                                <?php echo e(ucfirst($turma->turno)); ?>

                            </span>
                        </td>
                        <td class="align-middle">
                            <span class="badge bg-primary"><?php echo e($turma->matriculas()->count()); ?></span>
                        </td>
                        <td class="align-middle">
                            <div class="d-flex gap-1 flex-wrap">
                                <a href="<?php echo e(route('professor.notas', $turma->id)); ?>" class="btn-sm-custom">
                                    <i class="fas fa-edit"></i> Lançar Notas
                                </a>
                                <a href="<?php echo e(route('professor.materiais', $turma->id)); ?>" class="btn-sm-custom" style="background: #f59e0b;">
                                    <i class="fas fa-folder-open"></i> Materiais
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
<?php echo $__env->make('layouts.professor', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\colegio-genesis-oficial\resources\views/professor/dashboard.blade.php ENDPATH**/ ?>