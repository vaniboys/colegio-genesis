

<?php $__env->startSection('content'); ?>
<div class="card">
    <div class="card-header d-flex align-items-center gap-3">
        <a href="<?php echo e(route('professor.mensagens')); ?>" class="btn btn-sm btn-outline-secondary">
            <i class="fas fa-arrow-left"></i> Voltar
        </a>
        <div>
            <strong><?php echo e($outroUser->name); ?></strong>
            <div class="small text-muted">Aluno</div>
        </div>
    </div>
    
    <div class="card-body" style="height: 450px; overflow-y: auto;" id="mensagensContainer">
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $mensagens; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $msg): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
        <?php $isMine = $msg->user_id == auth()->id(); ?>
        <div class="mb-3" style="text-align: <?php echo e($isMine ? 'right' : 'left'); ?>;">
            <div style="display: inline-block; max-width: 70%; padding: 12px; border-radius: 12px; 
                 <?php echo e($isMine ? 'background: #3b82f6; color: white;' : 'background: #e5e7eb; color: #1e293b;'); ?>">
                <div><?php echo e($msg->mensagem); ?></div>
                <small style="font-size: 10px; opacity: 0.7;">
                    <?php echo e($msg->created_at->format('d/m/Y H:i')); ?>

                </small>
            </div>
        </div>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
    </div>
    
    <div class="card-footer">
        <form method="POST" action="/professor/mensagens/enviar">
            <?php echo csrf_field(); ?>
            <input type="hidden" name="conversa_id" value="<?php echo e($conversa->id); ?>">
            <div class="input-group">
                <input type="text" name="mensagem" class="form-control" placeholder="Digite sua mensagem..." required>
                <button type="submit" class="btn btn-primary"><i class="fas fa-paper-plane"></i></button>
            </div>
        </form>
    </div>
</div>

<script>
    var container = document.getElementById('mensagensContainer');
    container.scrollTop = container.scrollHeight;
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.professor', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\colegio-genesis-oficial\resources\views/professor/conversa.blade.php ENDPATH**/ ?>