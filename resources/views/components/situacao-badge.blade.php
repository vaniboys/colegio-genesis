@php
$config = [
    'aprovado' => ['class' => 'bg-success', 'icon' => 'fa-check-circle', 'text' => 'Aprovado'],
    'aprovado_exame' => ['class' => 'bg-info', 'icon' => 'fa-star', 'text' => 'Aprovado (Exame)'],
    'exame' => ['class' => 'bg-warning text-dark', 'icon' => 'fa-exclamation-triangle', 'text' => 'Exame'],
    'reprovado' => ['class' => 'bg-danger', 'icon' => 'fa-times-circle', 'text' => 'Reprovado'],
    'cursando' => ['class' => 'bg-secondary', 'icon' => 'fa-clock', 'text' => 'Cursando'],
];
$c = $config[$situacao] ?? $config['cursando'];
@endphp

<span class="badge {{ $c['class'] }} px-3 py-2">
    <i class="fas {{ $c['icon'] }}"></i> {{ $c['text'] }}
</span>