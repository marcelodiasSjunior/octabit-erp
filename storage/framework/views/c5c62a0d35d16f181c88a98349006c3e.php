<?php if (isset($component)) { $__componentOriginal5863877a5171c196453bfa0bd807e410 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5863877a5171c196453bfa0bd807e410 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.layouts.app','data' => ['title' => 'Oportunidades','header' => 'Oportunidades']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.app'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Oportunidades','header' => 'Oportunidades']); ?>
    <div class="card">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-sm font-semibold text-slate-200">Pipeline Comercial</h2>
            <a href="<?php echo e(route('deals.create')); ?>" class="btn-primary">Nova Oportunidade</a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="text-left text-slate-400 border-b border-bg-border">
                        <th class="py-2 pr-4">Titulo</th>
                        <th class="py-2 pr-4">Cliente</th>
                        <th class="py-2 pr-4">Etapa</th>
                        <th class="py-2 pr-4">Status</th>
                        <th class="py-2 pr-4">Valor</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $deals; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $deal): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr class="border-b border-bg-border/50">
                            <td class="py-2 pr-4">
                                <a class="text-octa-400 hover:text-octa-300" href="<?php echo e(route('deals.show', $deal)); ?>">
                                    <?php echo e($deal->title); ?>

                                </a>
                            </td>
                            <td class="py-2 pr-4"><?php echo e($deal->client->display_name); ?></td>
                            <td class="py-2 pr-4"><?php echo e($deal->stage->name); ?></td>
                            <td class="py-2 pr-4"><?php echo e($deal->status->label()); ?></td>
                            <td class="py-2 pr-4">R$ <?php echo e(number_format((float) $deal->value, 2, ',', '.')); ?></td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="5" class="py-6 text-slate-400">Nenhuma oportunidade cadastrada.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            <?php echo e($deals->links()); ?>

        </div>
    </div>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5863877a5171c196453bfa0bd807e410)): ?>
<?php $attributes = $__attributesOriginal5863877a5171c196453bfa0bd807e410; ?>
<?php unset($__attributesOriginal5863877a5171c196453bfa0bd807e410); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5863877a5171c196453bfa0bd807e410)): ?>
<?php $component = $__componentOriginal5863877a5171c196453bfa0bd807e410; ?>
<?php unset($__componentOriginal5863877a5171c196453bfa0bd807e410); ?>
<?php endif; ?>
<?php /**PATH /var/www/html/resources/views/deals/index.blade.php ENDPATH**/ ?>