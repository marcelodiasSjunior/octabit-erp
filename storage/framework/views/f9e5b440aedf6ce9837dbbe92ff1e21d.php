<?php if (isset($component)) { $__componentOriginal5863877a5171c196453bfa0bd807e410 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5863877a5171c196453bfa0bd807e410 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.layouts.app','data' => ['title' => 'Nova Oportunidade','header' => 'Nova Oportunidade']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.app'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Nova Oportunidade','header' => 'Nova Oportunidade']); ?>
    <div class="card max-w-4xl">
        <form method="POST" action="<?php echo e(route('deals.store')); ?>" class="space-y-4">
            <?php echo csrf_field(); ?>

            <div>
                <label class="label">Titulo</label>
                <input name="title" value="<?php echo e(old('title')); ?>" class="input" required />
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="label">Cliente</label>
                    <select name="client_id" class="input" required>
                        <option value="">Selecione um cliente</option>
                        <?php $__currentLoopData = $clients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $client): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($client->id); ?>" <?php if(old('client_id') == $client->id): echo 'selected'; endif; ?>>
                                <?php echo e($client->display_name); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>

                <div>
                    <label class="label">Pipeline</label>
                    <select name="pipeline_id" class="input" required>
                        <option value="">Selecione um pipeline</option>
                        <?php $__currentLoopData = $pipelines; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pipeline): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($pipeline->id); ?>" <?php if(old('pipeline_id') == $pipeline->id): echo 'selected'; endif; ?>>
                                <?php echo e($pipeline->name); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>

                <div>
                    <label class="label">Etapa</label>
                    <select name="stage_id" class="input" required>
                        <option value="">Selecione uma etapa</option>
                        <?php $__currentLoopData = $pipelines; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pipeline): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php $__currentLoopData = $pipeline->stages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $stage): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($stage->id); ?>" data-pipeline="<?php echo e($pipeline->id); ?>" <?php if(old('stage_id') == $stage->id): echo 'selected'; endif; ?>>
                                    <?php echo e($pipeline->name); ?> - <?php echo e($stage->name); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="label">Valor</label>
                    <input name="value" type="number" step="0.01" min="0" value="<?php echo e(old('value')); ?>" class="input" required />
                </div>
                <div>
                    <label class="label">Previsão de Fechamento</label>
                    <input name="expected_close_date" type="date" value="<?php echo e(old('expected_close_date')); ?>" class="input" />
                </div>
            </div>

            <div>
                <label class="label">Notas</label>
                <textarea name="notes" class="input" rows="4"><?php echo e(old('notes')); ?></textarea>
            </div>

            <div class="flex justify-end gap-3">
                <a href="<?php echo e(route('deals.index')); ?>" class="btn-ghost">Cancelar</a>
                <button type="submit" class="btn-primary">Salvar</button>
            </div>
        </form>
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
<?php /**PATH /var/www/html/resources/views/deals/create.blade.php ENDPATH**/ ?>