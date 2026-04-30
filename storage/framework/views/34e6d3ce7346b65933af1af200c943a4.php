

<?php $__env->startSection('content'); ?>
<div class="card">
    <div class="card-header">
        <i class="fas fa-tasks me-2"></i> Minhas Tarefas
    </div>
    <div class="card-body p-0">
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($tarefas->count() > 0): ?>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $tarefas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tarefa): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
            <div class="p-3 border-bottom">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <strong><?php echo e($tarefa->titulo); ?></strong>
                        <p class="small text-muted mb-1"><?php echo e(Str::limit($tarefa->descricao, 100)); ?></p>
                        <small class="text-muted">
                            <i class="fas fa-calendar"></i> Entrega: <?php echo e(date('d/m/Y', strtotime($tarefa->data_entrega))); ?>

                        </small>
                    </div>
                    <div>
                        <?php
                            $entrega = $tarefa->entregas->where('aluno_id', auth()->user()->aluno_id)->first();
                        ?>
                        
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($entrega && $entrega->status == 'corrigido'): ?>
                            <span class="badge bg-success">Nota: <?php echo e($entrega->nota); ?></span>
                        <?php elseif($entrega && $entrega->status == 'entregue'): ?>
                            <span class="badge bg-warning">Entregue</span>
                        <?php else: ?>
                            <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#modalEntrega<?php echo e($tarefa->id); ?>">
                                <i class="fas fa-upload"></i> Enviar
                            </button>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                </div>
            </div>
            
            <!-- Modal de Entrega -->
            <div class="modal fade" id="modalEntrega<?php echo e($tarefa->id); ?>" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form method="POST" action="<?php echo e(route('aluno.tarefa.enviar')); ?>" enctype="multipart/form-data">
                            <?php echo csrf_field(); ?>
                            <input type="hidden" name="tarefa_id" value="<?php echo e($tarefa->id); ?>">
                            <div class="modal-header">
                                <h5 class="modal-title">Enviar Tarefa: <?php echo e($tarefa->titulo); ?></h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label class="form-label">Arquivo</label>
                                    <input type="file" name="arquivo" class="form-control" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Comentário</label>
                                    <textarea name="comentario" class="form-control" rows="2"></textarea>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                <button type="submit" class="btn btn-primary">Enviar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
        <?php else: ?>
            <div class="text-center py-5">
                <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                <p class="text-muted">Nenhuma tarefa disponível</p>
            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.aluno', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\colegio-genesis-oficial\resources\views/aluno/tarefas.blade.php ENDPATH**/ ?>