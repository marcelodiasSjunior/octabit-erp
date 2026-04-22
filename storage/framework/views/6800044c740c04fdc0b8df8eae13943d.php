<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['label', 'value', 'icon' => null, 'color' => 'octa', 'sub' => null]));

foreach ($attributes->all() as $__key => $__value) {
    if (in_array($__key, $__propNames)) {
        $$__key = $$__key ?? $__value;
    } else {
        $__newAttributes[$__key] = $__value;
    }
}

$attributes = new \Illuminate\View\ComponentAttributeBag($__newAttributes);

unset($__propNames);
unset($__newAttributes);

foreach (array_filter((['label', 'value', 'icon' => null, 'color' => 'octa', 'sub' => null]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars); ?>

<?php
    $colors = [
        'octa'    => 'bg-octa-500/10 text-octa-400',
        'emerald' => 'bg-emerald-500/10 text-emerald-400',
        'blue'    => 'bg-blue-500/10 text-blue-400',
        'yellow'  => 'bg-yellow-500/10 text-yellow-400',
        'red'     => 'bg-red-500/10 text-red-400',
        'cyan'    => 'bg-cyan-500/10 text-cyan-400',
    ];
    $iconClass = $colors[$color] ?? $colors['octa'];
?>

<div class="stat-card">
    <?php if($icon): ?>
        <div class="stat-icon <?php echo e($iconClass); ?>">
            <?php echo $icon; ?>

        </div>
    <?php endif; ?>
    <div class="flex-1 min-w-0">
        <p class="text-xs text-slate-500 font-medium uppercase tracking-wider"><?php echo e($label); ?></p>
        <p class="mt-1 text-2xl font-bold text-slate-100"><?php echo e($value); ?></p>
        <?php if($sub): ?>
            <p class="mt-0.5 text-xs text-slate-500"><?php echo e($sub); ?></p>
        <?php endif; ?>
    </div>
</div>
<?php /**PATH /var/www/html/resources/views/components/stat-card.blade.php ENDPATH**/ ?>