<div class="p-6">
    <h2 class="text-lg font-bold text-gray-800 mb-4">📄 Emissão de Boletins e Relatórios</h2>
    
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        
        <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
            <div class="flex items-center gap-3 mb-4">
                <span class="text-2xl">📄</span>
                <div>
                    <h3 class="font-bold text-gray-800">Boletim Individual</h3>
                    <p class="text-xs text-gray-500">Selecione um aluno</p>
                </div>
            </div>
            
            <select id="alunoSelect" onchange="atualizarLink()" 
                class="w-full border border-gray-200 rounded-lg p-2.5 mb-3 text-sm">
                <option value="">🔍 Selecione um aluno...</option>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $this->getAlunos(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $aluno): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                    <option value="<?php echo e($aluno['id']); ?>"><?php echo e($aluno['label']); ?></option>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
            </select>
            
            <a href="#" id="boletimLink" target="_blank" 
               class="block w-full text-center bg-blue-600 text-white py-2.5 rounded-lg text-sm font-medium opacity-50 pointer-events-none">
                📄 Ver Boletim
            </a>
        </div>

        
        <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
            <div class="flex items-center gap-3 mb-4">
                <span class="text-2xl">📊</span>
                <div>
                    <h3 class="font-bold text-gray-800">Relatório por Turma</h3>
                    <p class="text-xs text-gray-500">Desempenho da turma</p>
                </div>
            </div>
            
            <select class="w-full border border-gray-200 rounded-lg p-2.5 mb-3 text-sm">
                <option value="">🔍 Selecione uma turma...</option>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $this->getTurmas(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $turma): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                    <option value="<?php echo e($turma['id']); ?>">
                        <?php echo e($turma['nome']); ?> (<?php echo e($turma['turno']); ?>) - <?php echo e($turma['alunos']); ?> alunos | <?php echo e($turma['vagas']); ?> vagas
                    </option>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
            </select>
            
            <button class="w-full bg-green-600 text-white py-2.5 rounded-lg text-sm font-medium">
                📊 Gerar Relatório
            </button>
        </div>
    </div>
</div>

<script>
    function atualizarLink() {
        const select = document.getElementById('alunoSelect');
        const link = document.getElementById('boletimLink');
        if (select.value) {
            link.href = '/aluno/boletim/pdf?id=' + select.value;
            link.classList.remove('opacity-50', 'pointer-events-none');
        } else {
            link.href = '#';
            link.classList.add('opacity-50', 'pointer-events-none');
        }
    }
</script><?php /**PATH C:\xampp\htdocs\colegio-genesis-oficial\resources\views/filament/widgets/boletim-stats.blade.php ENDPATH**/ ?>