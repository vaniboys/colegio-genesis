<div>
    
    <div style="margin-top: 32px;">
        <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('app.filament.widgets.estatisticas-gerais-widget');

$__keyOuter = $__key ?? null;

$__key = null;
$__componentSlots = [];

$__key ??= \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::generateKey('lw-4133600282-0', $__key);

$__html = app('livewire')->mount($__name, $__params, $__key, $__componentSlots);

echo $__html;

unset($__html);
unset($__key);
$__key = $__keyOuter;
unset($__keyOuter);
unset($__name);
unset($__params);
unset($__componentSlots);
unset($__split);
?>
    </div>

    
    <?php echo e($this->form); ?>

</div><?php /**PATH C:\xampp\htdocs\colegio-genesis-oficial\resources\views/filament/pages/boletins.blade.php ENDPATH**/ ?>