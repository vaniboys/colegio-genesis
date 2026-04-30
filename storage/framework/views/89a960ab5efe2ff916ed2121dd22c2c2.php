

<?php $__env->startSection('content'); ?>
<div class="table-card">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="mb-0" style="color: #1e3a8a;">
            <i class="fas fa-file-alt me-2"></i> Tarefas - <?php echo e($turma->nome); ?>

        </h5>
        <a href="<?php echo e(route('professor.tarefa.criar', $turma->id)); ?>" class="btn-sm-custom">
            <i class="fas fa-plus"></i> Nova Tarefa
        </a>
    </div>
    
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(isset($tarefas) && $tarefas->count() > 0): ?>
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Título</th>
                        <th>Descrição</th>
                        <th>Arquivo</th>
                        <th>Data Entrega</th>
                        <th>Pontuação</th>
                        <th>Entregas</th>
                        <th>Status</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $tarefas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tarefa): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                    <tr>
                        <td><strong><?php echo e($tarefa->titulo); ?></strong></td>
                        <td><?php echo e(Str::limit($tarefa->descricao, 50)); ?></td>
                        <td>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($tarefa->arquivo): ?>
                                <a href="<?php echo e(Storage::url($tarefa->arquivo)); ?>" class="btn-sm-custom" style="background: #10b981;" target="_blank">
                                    <i class="fas fa-download"></i> Baixar
                                </a>
                            <?php else: ?>
                                <span class="text-muted">-</span>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </td>
                        <td><?php echo e(date('d/m/Y', strtotime($tarefa->data_entrega))); ?></td>
                        <td><?php echo e($tarefa->pontuacao_maxima); ?> pts</td>
                        <td>
                            <span class="badge bg-primary">
                                <?php echo e($tarefa->entregas->count()); ?> / <?php echo e($turma->matriculas->count()); ?>

                            </span>
                        </td>
                        <td>
                            <span class="badge bg-<?php echo e($tarefa->publicado ? 'success' : 'secondary'); ?>">
                                <?php echo e($tarefa->publicado ? 'Publicado' : 'Rascunho'); ?>

                            </span>
                        </td>
                        <td>
                            <div class="d-flex gap-1">
                                <a href="<?php echo e(route('professor.tarefa.entregas', $tarefa->id)); ?>" class="btn-sm-custom" style="background: #f59e0b;">
                                    <i class="fas fa-check-circle"></i> Corrigir
                                </a>
                                <a href="<?php echo e(route('professor.tarefa.editar', $tarefa->id)); ?>" class="btn-sm-custom">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="<?php echo e(route('professor.tarefa.deletar', $tarefa->id)); ?>" method="POST" class="d-inline">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button type="submit" class="btn-sm-custom" style="background: #dc2626;" onclick="return confirm('Deletar esta tarefa?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <div class="alert alert-info">
            <i class="fas fa-info-circle"></i> Nenhuma tarefa criada.
        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.professor', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\colegio-genesis-oficial\resources\views/professor/tarefas.blade.php ENDPATH**/ ?>