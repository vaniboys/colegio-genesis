

<?php $__env->startSection('content'); ?>
<div class="card">
    <div class="card-header d-flex align-items-center gap-3">
        <a href="<?php echo e(route('aluno.mensagens')); ?>" class="btn btn-sm btn-outline-secondary">
            <i class="fas fa-arrow-left"></i> Voltar
        </a>
        <div>
            <strong><?php echo e($outroUser->name); ?></strong>
            <div class="small text-muted">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($outroUser->role == 'professor'): ?> Professor
                <?php elseif($outroUser->role == 'aluno'): ?> Aluno
                <?php else: ?> <?php echo e(ucfirst($outroUser->role)); ?>

                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
        </div>
    </div>
    
    <div class="card-body" style="height: 450px; overflow-y: auto;" id="mensagensContainer">
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $mensagens; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $msg): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
        <?php $isMine = $msg->user_id == auth()->id(); ?>
        <div class="mb-3 d-flex <?php echo e($isMine ? 'justify-content-end' : 'justify-content-start'); ?>">
            <div class="p-3 rounded-3" style="max-width: 70%; <?php echo e($isMine ? 'background: #3b82f6; color: white;' : 'background: #f1f5f9; color: #1e293b;'); ?>">
                <div><?php echo e($msg->mensagem); ?></div>
                <small class="d-block mt-1 <?php echo e($isMine ? 'text-white-50' : 'text-muted'); ?>" style="font-size: 10px;">
                    <?php echo e($msg->created_at->format('d/m/Y H:i')); ?> · <?php echo e($isMine ? 'Você' : $outroUser->name); ?>

                </small>
            </div>
        </div>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
    </div>
    
    <div class="card-footer">
        <form method="POST" action="/aluno/mensagens/enviar">
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
<?php echo $__env->make('layouts.aluno', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\colegio-genesis-oficial\resources\views/aluno/conversa.blade.php ENDPATH**/ ?>