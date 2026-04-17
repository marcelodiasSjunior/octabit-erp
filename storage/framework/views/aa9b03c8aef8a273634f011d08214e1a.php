<?php if (isset($component)) { $__componentOriginal5863877a5171c196453bfa0bd807e410 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5863877a5171c196453bfa0bd807e410 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.layouts.app','data' => ['title' => 'Orçamento #'.e($quote->id).'','header' => 'Orçamentos / #'.e($quote->id).'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.app'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Orçamento #'.e($quote->id).'','header' => 'Orçamentos / #'.e($quote->id).'']); ?>

    
    <?php if(session('success')): ?>
        <div class="mb-4 px-4 py-3 rounded-lg bg-green-500/10 border border-green-500/30 text-green-400 text-sm">
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>
    <?php if(session('error')): ?>
        <div class="mb-4 px-4 py-3 rounded-lg bg-red-500/10 border border-red-500/30 text-red-400 text-sm">
            <?php echo e(session('error')); ?>

        </div>
    <?php endif; ?>

    <div class="max-w-4xl space-y-4">

        
        <div class="card flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4">
            <div>
                <div class="flex items-center gap-3 mb-2">
                    <h1 class="text-xl font-bold text-slate-100">Orçamento #<?php echo e($quote->id); ?></h1>
                    <?php if (isset($component)) { $__componentOriginal8c81617a70e11bcf247c4db924ab1b62 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal8c81617a70e11bcf247c4db924ab1b62 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.status-badge','data' => ['status' => $quote->status]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('status-badge'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['status' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($quote->status)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal8c81617a70e11bcf247c4db924ab1b62)): ?>
<?php $attributes = $__attributesOriginal8c81617a70e11bcf247c4db924ab1b62; ?>
<?php unset($__attributesOriginal8c81617a70e11bcf247c4db924ab1b62); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8c81617a70e11bcf247c4db924ab1b62)): ?>
<?php $component = $__componentOriginal8c81617a70e11bcf247c4db924ab1b62; ?>
<?php unset($__componentOriginal8c81617a70e11bcf247c4db924ab1b62); ?>
<?php endif; ?>
                </div>
                <p class="text-sm text-slate-400">
                    Cliente: <span class="text-slate-200 font-medium"><?php echo e($quote->client->name ?? '—'); ?></span>
                </p>
                <p class="text-sm text-slate-400">
                    Criado em: <span class="text-slate-300"><?php echo e($quote->created_at->format('d/m/Y H:i')); ?></span>
                </p>
                <?php if($quote->valid_until): ?>
                    <p class="text-sm text-slate-400">
                        Válido até:
                        <span class="<?php echo \Illuminate\Support\Arr::toCssClasses(['text-red-400' => $quote->valid_until->isPast() && $quote->status->value !== 'approved', 'text-slate-300' => !$quote->valid_until->isPast() || $quote->status->value === 'approved']); ?>">
                            <?php echo e($quote->valid_until->format('d/m/Y')); ?>

                        </span>
                    </p>
                <?php endif; ?>
                <?php if($quote->converted_to_sale_at): ?>
                    <p class="text-sm text-green-400 mt-1">
                        Convertido em <?php echo e($quote->converted_to_sale_at->format('d/m/Y H:i')); ?>

                    </p>
                <?php endif; ?>
            </div>

            
            <div class="flex flex-wrap gap-2 shrink-0">
                <?php if($quote->status->value === 'draft'): ?>
                    <a href="<?php echo e(route('quotes.edit', $quote->id)); ?>" class="btn-ghost btn-sm">
                        Editar
                    </a>
                    <form method="POST" action="<?php echo e(route('quotes.send', $quote->id)); ?>">
                        <?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?>
                        <button type="submit" class="btn-primary btn-sm">Marcar como Enviado</button>
                    </form>
                <?php endif; ?>

                <?php if($quote->status->value === 'sent'): ?>
                    <form method="POST" action="<?php echo e(route('quotes.approve', $quote->id)); ?>">
                        <?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?>
                        <button type="submit" class="btn-primary btn-sm bg-green-600 hover:bg-green-500">Aprovar</button>
                    </form>
                    <form method="POST" action="<?php echo e(route('quotes.reject', $quote->id)); ?>"
                          x-data @submit.prevent="if(confirm('Rejeitar este orçamento?')) $el.submit()">
                        <?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?>
                        <button type="submit" class="btn-ghost btn-sm text-red-400 hover:text-red-300">Rejeitar</button>
                    </form>
                <?php endif; ?>

                <a href="<?php echo e(route('api.quotes.pdf', $quote->id)); ?>" target="_blank" class="btn-ghost btn-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                    </svg>
                    PDF
                </a>

                <a href="<?php echo e(route('quotes.index')); ?>" class="btn-ghost btn-sm">← Voltar</a>
            </div>
        </div>

        
        <div class="card">
            <h2 class="text-base font-semibold text-slate-200 mb-4">Itens do Orçamento</h2>

            <div class="table-wrapper">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Descrição</th>
                            <th class="text-right">Qtd</th>
                            <th class="text-right">Preço unit.</th>
                            <th class="text-right">Desc. %</th>
                            <th class="text-right">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $quote->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($item->description); ?></td>
                                <td class="text-right font-mono text-sm"><?php echo e(number_format($item->quantity, 2, ',', '.')); ?></td>
                                <td class="text-right font-mono text-sm">R$ <?php echo e(number_format($item->unit_price, 2, ',', '.')); ?></td>
                                <td class="text-right font-mono text-sm text-slate-400">
                                    <?php echo e($item->discount > 0 ? number_format($item->discount, 2, ',', '.') . '%' : '—'); ?>

                                </td>
                                <td class="text-right font-semibold text-octa-300">R$ <?php echo e(number_format($item->line_total, 2, ',', '.')); ?></td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>

            
            <div class="mt-6 flex flex-col items-end gap-1 text-sm border-t border-bg-border pt-4">
                <div class="flex gap-6 text-slate-400">
                    <span>Subtotal</span>
                    <span class="w-32 text-right">R$ <?php echo e(number_format($quote->subtotal, 2, ',', '.')); ?></span>
                </div>
                <?php if($quote->discount_total > 0): ?>
                    <div class="flex gap-6 text-red-400">
                        <span>Descontos</span>
                        <span class="w-32 text-right">- R$ <?php echo e(number_format($quote->discount_total, 2, ',', '.')); ?></span>
                    </div>
                <?php endif; ?>
                <div class="flex gap-6 text-slate-100 font-bold text-base mt-1">
                    <span>Total</span>
                    <span class="w-32 text-right text-octa-300">R$ <?php echo e(number_format($quote->total, 2, ',', '.')); ?></span>
                </div>
            </div>
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
<?php /**PATH /var/www/html/resources/views/quotes/show.blade.php ENDPATH**/ ?>