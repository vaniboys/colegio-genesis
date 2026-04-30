

<?php $__env->startSection('content'); ?>
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span><i class="fas fa-envelope me-2"></i> Minhas Conversas</span>
        <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#novaConversaModal">
            <i class="fas fa-plus"></i> Nova Conversa
        </button>
    </div>
    <div class="card-body p-0">
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($conversas->count() > 0): ?>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $conversas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $conversa): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
            <a href="<?php echo e(route('aluno.conversa', $conversa->id)); ?>" class="text-decoration-none">
                <div class="d-flex justify-content-between align-items-center p-3 border-bottom hover-bg">
                    <div class="d-flex align-items-center gap-3">
                        <div>
                            <i class="fas fa-user-circle fa-2x text-secondary"></i>
                        </div>
                        <div>
                            <strong><?php echo e($conversa->outroUser->name); ?></strong>
                            <div class="small text-muted"><?php echo e(ucfirst($conversa->outroUser->role)); ?></div>
                            <?php $ultimaMsg = $conversa->mensagens->last(); ?>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($ultimaMsg): ?>
                                <small class="text-muted"><?php echo e(Str::limit($ultimaMsg->mensagem, 40)); ?></small>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                    </div>
                    <div class="text-end">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($conversa->mensagens->where('lida', false)->where('user_id', '!=', auth()->id())->count() > 0): ?>
                            <span class="badge bg-danger rounded-pill">
                                <?php echo e($conversa->mensagens->where('lida', false)->where('user_id', '!=', auth()->id())->count()); ?>

                            </span>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        <div class="small text-muted">
                            <?php echo e($conversa->ultima_mensagem ? $conversa->ultima_mensagem->diffForHumans() : 'Sem mensagens'); ?>

                        </div>
                    </div>
                </div>
            </a>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
        <?php else: ?>
            <div class="text-center py-5">
                <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                <p class="text-muted">Nenhuma conversa ainda</p>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#novaConversaModal">
                    <i class="fas fa-plus"></i> Iniciar conversa com seu professor
                </button>
            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>
</div>

<!-- Modal Nova Conversa -->
<div class="modal fade" id="novaConversaModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-user-plus me-2"></i> Nova Conversa</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-info">
                    <i class="fas fa-info-circle me-2"></i>
                    Você pode conversar com seus professores.
                </div>
                <div class="mb-3">
                    <label class="form-label">Selecione o professor</label>
                    <select id="professorSelect" class="form-control" required>
                        <option value="">Carregando professores...</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" onclick="iniciarConversa()">
                    <i class="fas fa-comment"></i> Iniciar Conversa
                </button>
            </div>
        </div>
    </div>
</div>

<style>
    .hover-bg:hover {
        background-color: #f8f9fa;
        transform: translateX(5px);
        transition: all 0.3s;
    }
</style>

<?php $__env->startPush('scripts'); ?>
<script>
    function carregarProfessores() {
        fetch('<?php echo e(route("aluno.buscar-professores")); ?>')
            .then(response => response.json())
            .then(data => {
                let select = document.getElementById('professorSelect');
                if(data.length > 0) {
                    select.innerHTML = '<option value="">Selecione um professor...</option>';
                    data.forEach(professor => {
                        select.innerHTML += `<option value="${professor.id}">${professor.name} - ${professor.disciplina}</option>`;
                    });
                } else {
                    select.innerHTML = '<option value="">Nenhum professor encontrado</option>';
                }
            })
            .catch(error => {
                console.error('Erro:', error);
                document.getElementById('professorSelect').innerHTML = '<option value="">Erro ao carregar professores</option>';
            });
    }
    
    function iniciarConversa() {
        let professorId = document.getElementById('professorSelect').value;
        if(!professorId) {
            alert('Selecione um professor');
            return;
        }
        
        let form = document.createElement('form');
        form.method = 'POST';
        form.action = '<?php echo e(route("aluno.nova-conversa")); ?>';
        form.innerHTML = '<?php echo csrf_field(); ?><input type="hidden" name="professor_id" value="' + professorId + '">';
        document.body.appendChild(form);
        form.submit();
    }
    
    document.addEventListener('DOMContentLoaded', function() {
        carregarProfessores();
    });
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.aluno', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\colegio-genesis-oficial\resources\views/aluno/mensagens.blade.php ENDPATH**/ ?>