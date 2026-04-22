<?php if (isset($component)) { $__componentOriginal5863877a5171c196453bfa0bd807e410 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5863877a5171c196453bfa0bd807e410 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.layouts.app','data' => ['title' => $deal->title,'header' => 'Detalhe da Oportunidade']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.app'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($deal->title),'header' => 'Detalhe da Oportunidade']); ?>
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        
        <div class="lg:col-span-2 space-y-6">
            <div class="card">
                <h2 class="text-lg font-semibold text-slate-100"><?php echo e($deal->title); ?></h2>
                <?php if($deal->notes): ?>
                    <p class="text-slate-400 mt-2 text-sm"><?php echo e($deal->notes); ?></p>
                <?php endif; ?>

                <dl class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-6 text-sm">
                    <div>
                        <dt class="text-slate-500">Cliente</dt>
                        <dd class="text-slate-200"><?php echo e($deal->client->display_name); ?></dd>
                    </div>
                    <div>
                        <dt class="text-slate-500">Pipeline</dt>
                        <dd class="text-slate-200"><?php echo e($deal->pipeline->name); ?></dd>
                    </div>
                    <div>
                        <dt class="text-slate-500">Etapa</dt>
                        <dd class="text-slate-200"><?php echo e($deal->stage->name); ?></dd>
                    </div>
                    <div>
                        <dt class="text-slate-500">Status</dt>
                        <dd class="text-slate-200"><?php echo e($deal->status->label()); ?></dd>
                    </div>
                    <div>
                        <dt class="text-slate-500">Valor</dt>
                        <dd class="text-slate-200 font-semibold">R$ <?php echo e(number_format((float) $deal->value, 2, ',', '.')); ?></dd>
                    </div>
                    <div>
                        <dt class="text-slate-500">Previsão de Fechamento</dt>
                        <dd class="text-slate-200"><?php echo e(optional($deal->expected_close_date)->format('d/m/Y') ?? '—'); ?></dd>
                    </div>
                </dl>
            </div>

            
            <div class="card">
                <h3 class="text-sm font-semibold text-slate-200 mb-4">Atividades</h3>

                <?php $__empty_1 = true; $__currentLoopData = $deal->activities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $activity): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="flex items-start gap-3 py-3 border-b border-bg-border/50 last:border-0">
                        <div class="mt-0.5">
                            <?php if($activity->done): ?>
                                <span class="w-5 h-5 rounded-full bg-emerald-500/20 border border-emerald-500/40 flex items-center justify-center">
                                    <svg class="w-3 h-3 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                    </svg>
                                </span>
                            <?php elseif($activity->scheduled_at->isPast()): ?>
                                <span class="w-5 h-5 rounded-full bg-red-500/20 border border-red-500/40 block"></span>
                            <?php else: ?>
                                <span class="w-5 h-5 rounded-full bg-bg-elevated border border-bg-border block"></span>
                            <?php endif; ?>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-slate-200 <?php echo e($activity->done ? 'line-through text-slate-500' : ''); ?>">
                                <?php echo e($activity->title); ?>

                            </p>
                            <p class="text-xs text-slate-500 mt-0.5">
                                <?php echo e($activity->type->label()); ?> · <?php echo e($activity->scheduled_at->format('d/m/Y H:i')); ?>

                                <?php if($activity->user): ?> · <?php echo e($activity->user->name); ?> <?php endif; ?>
                            </p>
                            <?php if($activity->notes): ?>
                                <p class="text-xs text-slate-400 mt-1"><?php echo e($activity->notes); ?></p>
                            <?php endif; ?>
                        </div>
                        <div class="flex items-center gap-2 shrink-0">
                            <?php if (! ($activity->done)): ?>
                                <form method="POST" action="<?php echo e(route('deals.activities.complete', [$deal, $activity])); ?>">
                                    <?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?>
                                    <button type="submit" class="text-xs text-emerald-400 hover:text-emerald-300">Concluir</button>
                                </form>
                            <?php endif; ?>
                            <form method="POST" action="<?php echo e(route('deals.activities.destroy', [$deal, $activity])); ?>">
                                <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                <button type="submit" class="text-xs text-slate-500 hover:text-red-400">Remover</button>
                            </form>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <p class="text-slate-500 text-sm">Nenhuma atividade registrada.</p>
                <?php endif; ?>

                
                <details class="mt-4">
                    <summary class="cursor-pointer text-sm text-octa-400 hover:text-octa-300 font-medium">+ Nova atividade</summary>
                    <form method="POST" action="<?php echo e(route('deals.activities.store', $deal)); ?>" class="mt-3 space-y-3">
                        <?php echo csrf_field(); ?>
                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="label">Tipo</label>
                                <select name="type" class="input" required>
                                    <?php $__currentLoopData = \App\Enums\DealActivityType::cases(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($type->value); ?>"><?php echo e($type->label()); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                            <div>
                                <label class="label">Data/Hora</label>
                                <input name="scheduled_at" type="datetime-local" class="input" required />
                            </div>
                        </div>
                        <div>
                            <label class="label">Título</label>
                            <input name="title" class="input" required />
                        </div>
                        <div>
                            <label class="label">Notas</label>
                            <textarea name="notes" class="input" rows="2"></textarea>
                        </div>
                        <button type="submit" class="btn-primary">Salvar Atividade</button>
                    </form>
                </details>
            </div>
        </div>

        
        <div class="space-y-4">
            <div class="card">
                <h3 class="text-sm font-semibold text-slate-200 mb-3">Mover Etapa</h3>
                <form method="POST" action="<?php echo e(route('deals.move-stage', $deal)); ?>" class="space-y-3">
                    <?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?>
                    <select name="stage_id" class="input" required>
                        <?php $__currentLoopData = $deal->pipeline->stages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $stage): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($stage->id); ?>" <?php if($deal->stage_id === $stage->id): echo 'selected'; endif; ?>>
                                <?php echo e($stage->name); ?> (<?php echo e($stage->probability); ?>%)
                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                    <button type="submit" class="btn-primary w-full">Atualizar</button>
                </form>
            </div>

            <div class="card space-y-3">
                <a href="<?php echo e(route('deals.edit', $deal)); ?>" class="btn-ghost w-full text-center">Editar</a>
                <a href="<?php echo e(route('deals.kanban', $deal->pipeline_id)); ?>" class="btn-ghost w-full text-center">Ver Kanban</a>
                <form method="POST" action="<?php echo e(route('deals.destroy', $deal)); ?>">
                    <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                    <button type="submit" class="btn-danger w-full">Excluir</button>
                </form>
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
<?php /**PATH /var/www/html/resources/views/deals/show.blade.php ENDPATH**/ ?>