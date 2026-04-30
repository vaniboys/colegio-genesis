<?php
$config = [
    'aprovado' => ['class' => 'bg-success', 'icon' => 'fa-check-circle', 'text' => 'Aprovado'],
    'aprovado_exame' => ['class' => 'bg-info', 'icon' => 'fa-star', 'text' => 'Aprovado (Exame)'],
    'exame' => ['class' => 'bg-warning text-dark', 'icon' => 'fa-exclamation-triangle', 'text' => 'Exame'],
    'reprovado' => ['class' => 'bg-danger', 'icon' => 'fa-times-circle', 'text' => 'Reprovado'],
    'cursando' => ['class' => 'bg-secondary', 'icon' => 'fa-clock', 'text' => 'Cursando'],
];
$c = $config[$situacao] ?? $config['cursando'];
?>

<span class="badge <?php echo e($c['class']); ?> px-3 py-2">
    <i class="fas <?php echo e($c['icon']); ?>"></i> <?php echo e($c['text']); ?>

</span><?php /**PATH C:\xampp\htdocs\colegio-genesis-oficial\resources\views/components/situacao-badge.blade.php ENDPATH**/ ?>