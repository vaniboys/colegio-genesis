

<?php $__env->startSection('content'); ?>
<div class="container-fluid px-4">
    
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-1 text-primary">
                <i class="fas fa-book me-2"></i> Meus Livros
            </h4>
            <nav>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="<?php echo e(route('aluno.dashboard')); ?>">Dashboard</a></li>
                    <li class="breadcrumb-item active">Livros</li>
                </ol>
            </nav>
        </div>
        <span class="badge bg-primary px-3 py-2">
            <i class="fas fa-graduation-cap me-1"></i> <?php echo e($classe->nome ?? 'Minha Turma'); ?>

        </span>
    </div>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(isset($error)): ?>
        <div class="alert alert-warning"><?php echo e($error); ?></div>
    <?php elseif($livros->count() > 0): ?>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $livrosPorDisciplina; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $disciplinaNome => $livrosDisciplina): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
        <div class="card mb-4">
            <div class="card-header bg-white">
                <div class="d-flex align-items-center gap-2">
                    <i class="fas fa-book-open text-primary fs-5"></i>
                    <strong class="fs-5"><?php echo e($disciplinaNome); ?></strong>
                    <span class="badge bg-secondary rounded-pill"><?php echo e($livrosDisciplina->count()); ?></span>
                </div>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $livrosDisciplina; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $livro): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                    <div class="col-md-6 col-lg-4 col-xl-3">
                        <div class="card livro-card h-100">
                            <div class="row g-0 h-100">
                                <div class="col-4">
                                    <?php
                                        $capaUrl = $livro->capa && Storage::disk('public')->exists($livro->capa) 
                                            ? Storage::url($livro->capa) 
                                            : 'https://ui-avatars.com/api/?background=1e3a8a&color=fff&size=120&length=2&name=' . urlencode(substr($livro->titulo, 0, 2));
                                    ?>
                                    <div class="livro-capa">
                                        <img src="<?php echo e($capaUrl); ?>" class="img-fluid w-100 h-100" style="object-fit: cover;" alt="Capa">
                                    </div>
                                </div>
                                <div class="col-8">
                                    <div class="card-body p-2 p-md-3">
                                        <h6 class="card-title fw-bold mb-1"><?php echo e(Str::limit($livro->titulo, 40)); ?></h6>
                                        <p class="small text-muted mb-1">
                                            <i class="fas fa-user-edit me-1"></i> <?php echo e($livro->autor ?? 'Autor'); ?>

                                        </p>
                                        <p class="small text-muted mb-2">
                                            <i class="fas fa-download me-1"></i> <?php echo e($livro->downloads ?? 0); ?>

                                        </p>
                                        <a href="<?php echo e(route('aluno.download-livro', $livro->id)); ?>" class="btn btn-sm btn-primary w-100">
                                            <i class="fas fa-download me-1"></i> Baixar
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                </div>
            </div>
        </div>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
    <?php else: ?>
        <div class="card">
            <div class="card-body text-center py-5">
                <i class="fas fa-book fa-4x text-muted mb-3"></i>
                <h5 class="text-muted">Nenhum livro disponível</h5>
                <p class="text-muted small">Os livros serão disponibilizados em breve.</p>
            </div>
        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>
<style>
    .livro-card {
        transition: transform 0.2s, box-shadow 0.2s;
        border: 1px solid #e9ecef;
        border-radius: 10px;
        overflow: hidden;
    }
    .livro-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }
    .livro-capa {
        height: 140px;
        background: linear-gradient(135deg, #1e3a8a, #3b82f6);
        overflow: hidden;
    }
    @media (max-width: 768px) {
        .livro-capa { height: 110px; }
        .card-title { font-size: 0.8rem; }
    }
</style>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.aluno', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\colegio-genesis-oficial\resources\views/aluno/livros.blade.php ENDPATH**/ ?>