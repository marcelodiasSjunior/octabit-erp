<?php if (isset($component)) { $__componentOriginal5863877a5171c196453bfa0bd807e410 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5863877a5171c196453bfa0bd807e410 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.layouts.app','data' => ['title' => 'Kanban — ' . $pipeline->name,'header' => 'Kanban — ' . $pipeline->name]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.app'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('Kanban — ' . $pipeline->name),'header' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('Kanban — ' . $pipeline->name)]); ?>

    <div class="mb-4 flex items-center justify-between">
        <a href="<?php echo e(route('deals.index')); ?>" class="text-sm text-slate-400 hover:text-slate-200">← Lista de Oportunidades</a>
        <a href="<?php echo e(route('deals.create')); ?>" class="btn-primary">+ Nova Oportunidade</a>
    </div>

    
    <div class="flex gap-4 overflow-x-auto pb-4" x-data="kanban()">
        <?php $__currentLoopData = $pipeline->stages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $stage): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div
                class="flex-shrink-0 w-72 bg-bg-secondary rounded-xl border border-bg-border flex flex-col"
                x-on:dragover.prevent
                x-on:drop="onDrop($event, <?php echo e($stage->id); ?>)"
                data-stage="<?php echo e($stage->id); ?>"
            >
                
                <div class="px-4 py-3 border-b border-bg-border flex items-center justify-between">
                    <div>
                        <span class="text-sm font-semibold text-slate-200"><?php echo e($stage->name); ?></span>
                        <span class="ml-2 text-xs text-slate-500"><?php echo e($stage->probability); ?>%</span>
                    </div>
                    <span class="text-xs text-slate-500 tabular-nums">
                        <?php echo e($stage->deals->count()); ?>

                    </span>
                </div>

                
                <div class="flex-1 p-3 space-y-2 min-h-[120px]">
                    <?php $__currentLoopData = $stage->deals; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $deal): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div
                            class="bg-bg-elevated border border-bg-border rounded-lg p-3 cursor-grab active:cursor-grabbing hover:border-octa-500/40 transition-colors"
                            draggable="true"
                            x-on:dragstart="onDragStart($event, <?php echo e($deal->id); ?>)"
                        >
                            <a href="<?php echo e(route('deals.show', $deal)); ?>" class="block">
                                <p class="text-sm font-medium text-slate-200 leading-snug"><?php echo e($deal->title); ?></p>
                                <p class="text-xs text-slate-500 mt-1"><?php echo e($deal->client->display_name); ?></p>
                                <p class="text-xs text-octa-400 font-semibold mt-2">R$ <?php echo e(number_format((float) $deal->value, 2, ',', '.')); ?></p>
                            </a>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>

    <script>
    function kanban() {
        return {
            draggingDealId: null,

            onDragStart(event, dealId) {
                this.draggingDealId = dealId;
                event.dataTransfer.effectAllowed = 'move';
            },

            async onDrop(event, stageId) {
                if (!this.draggingDealId) return;

                const dealId = this.draggingDealId;
                this.draggingDealId = null;

                const url = `/deals/${dealId}/move-stage`;

                await fetch(url, {
                    method: 'PATCH',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({ stage_id: stageId }),
                });

                window.location.reload();
            },
        };
    }
    </script>
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
<?php /**PATH /var/www/html/resources/views/deals/kanban.blade.php ENDPATH**/ ?>