

<?php $__env->startSection('content'); ?>
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span><i class="fas fa-bell me-2"></i> Minhas Notificações</span>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($notificacoes->where('lida', false)->count() > 0): ?>
        <button class="btn btn-sm btn-primary" onclick="marcarTodasLidas()">
            <i class="fas fa-check-double"></i> Marcar todas como lidas
        </button>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>
    <div class="card-body p-0">
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($notificacoes->count() > 0): ?>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $notificacoes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $notificacao): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
            <div class="notification-item p-3 border-bottom <?php echo e(!$notificacao->lida ? 'unread' : ''); ?>" data-id="<?php echo e($notificacao->id); ?>">
                <div class="d-flex justify-content-between">
                    <div class="flex-grow-1">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <strong><?php echo e($notificacao->titulo); ?></strong>
                            <small class="text-muted"><?php echo e($notificacao->created_at->diffForHumans()); ?></small>
                        </div>
                        <p class="mb-1"><?php echo e($notificacao->mensagem); ?></p>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($notificacao->link): ?>
                            <a href="<?php echo e($notificacao->link); ?>" class="btn btn-sm btn-outline-primary mt-2">
                                Ver detalhes <i class="fas fa-arrow-right ms-1"></i>
                            </a>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!$notificacao->lida): ?>
                        <button class="btn btn-sm btn-link text-success" onclick="marcarComoLida(<?php echo e($notificacao->id); ?>)">
                            <i class="fas fa-check-circle"></i>
                        </button>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
            </div>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
        <?php else: ?>
            <div class="text-center py-5">
                <i class="fas fa-bell-slash fa-3x text-muted mb-3"></i>
                <p class="text-muted">Nenhuma notificação encontrada</p>
                <small class="text-muted">As notificações aparecerão aqui quando houver novidades</small>
            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>
</div>

<style>
    .notification-item {
        transition: all 0.3s;
        cursor: pointer;
    }
    .notification-item:hover {
        background-color: #f8fafc;
        transform: translateX(5px);
    }
    .notification-item.unread {
        background-color: #e0e7ff;
        border-left: 3px solid #1e3a8a;
    }
</style>

<?php $__env->startPush('scripts'); ?>
<script>
    function marcarComoLida(id) {
        fetch('/aluno/notificacao/marcar-lida/' + id, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>',
                'Content-Type': 'application/json'
            }
        }).then(response => {
            if(response.ok) {
                location.reload();
            }
        });
    }
    
    function marcarTodasLidas() {
        fetch('/aluno/notificacoes/marcar-todas', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>',
                'Content-Type': 'application/json'
            }
        }).then(response => {
            if(response.ok) {
                location.reload();
            }
        });
    }
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.aluno', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\colegio-genesis-oficial\resources\views/aluno/notificacoes.blade.php ENDPATH**/ ?>