<div style="background: white; border-radius: 12px; padding: 16px; border: 1px solid #e2e8f0;">
    <h3 style="font-weight: 700; margin-bottom: 12px;">Alertas</h3>
    
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($turmasSemProfessor > 0): ?>
        <div style="background: #fef2f2; padding: 12px; border-radius: 8px; margin-bottom: 8px;">
            <p style="color: #dc2626; font-weight: 600; margin: 0;"><?php echo e($turmasSemProfessor); ?> turma(s) sem professor</p>
        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($alunosInadimplentes > 0): ?>
        <div style="background: #fffbeb; padding: 12px; border-radius: 8px;">
            <p style="color: #d97706; font-weight: 600; margin: 0;"><?php echo e($alunosInadimplentes); ?> aluno(s) inadimplentes</p>
        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($turmasSemProfessor == 0 && $alunosInadimplentes == 0): ?>
        <div style="background: #f0fdf4; padding: 12px; border-radius: 8px;">
            <p style="color: #16a34a; font-weight: 600; margin: 0;">✅ Tudo em ordem!</p>
        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
</div><?php /**PATH C:\xampp\htdocs\colegio-genesis-oficial\resources\views/filament/widgets/alertas-widget.blade.php ENDPATH**/ ?>