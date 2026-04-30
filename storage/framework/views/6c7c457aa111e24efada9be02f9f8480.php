

<?php $__env->startSection('content'); ?>
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">
            <i class="fas fa-users me-2"></i> Alunos da Turma - <?php echo e($turma->nome); ?>

        </h5>
        <a href="<?php echo e(route('professor.turmas')); ?>" class="btn-back">
            <i class="fas fa-arrow-left"></i> Voltar
        </a>
    </div>
    <div class="card-body p-0">
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($alunos->count() > 0): ?>
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Processo</th>
                            <th>Nome Completo</th>
                            <th>BI</th>
                            <th>Data Nascimento</th>
                            <th>Contacto</th>
                            <th>Email</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $alunos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $aluno): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                        <tr>
                            <td><?php echo e($index + 1); ?></td>
                            
                            <td><?php echo e($aluno->processo ?? '-'); ?></td>
                            <td><strong><?php echo e($aluno->nome_completo); ?></strong></td>
                            <td><?php echo e($aluno->bi ?? '-'); ?></td>
                            <td><?php echo e($aluno->data_nascimento ? date('d/m/Y', strtotime($aluno->data_nascimento)) : '-'); ?></td>
                            <td><?php echo e($aluno->telefone ?? $aluno->contacto_principal ?? '-'); ?></td>
                            <td><?php echo e($aluno->email ?? '-'); ?></td>
                        </tr>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    </tbody>
                </table>
            </div>
            <div class="p-3 bg-light">
                <strong>Total de Alunos:</strong> <?php echo e($alunos->count()); ?>

            </div>
        <?php else: ?>
            <div class="text-center py-5">
                <i class="fas fa-users-slash fa-3x text-muted mb-3"></i>
                <p class="text-muted">Nenhum aluno matriculado nesta turma</p>
            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.professor', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\colegio-genesis-oficial\resources\views/professor/alunos-turma.blade.php ENDPATH**/ ?>