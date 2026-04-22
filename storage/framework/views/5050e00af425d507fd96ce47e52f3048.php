<?php if (isset($component)) { $__componentOriginal5863877a5171c196453bfa0bd807e410 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5863877a5171c196453bfa0bd807e410 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.layouts.app','data' => ['title' => 'Configurações de Follow-up','header' => 'Configurações de Follow-up']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.app'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Configurações de Follow-up','header' => 'Configurações de Follow-up']); ?>
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="card">
            <h2 class="text-lg font-semibold text-slate-100 mb-4">Novo SLA</h2>
            <form method="POST" action="<?php echo e(route('followups.settings.slas.store')); ?>" class="space-y-3">
                <?php echo csrf_field(); ?>
                <div>
                    <label class="form-label">Pipeline</label>
                    <select name="pipeline_id" class="form-input" required>
                        <?php $__currentLoopData = $pipelines; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pipeline): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($pipeline->id); ?>"><?php echo e($pipeline->name); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div>
                    <label class="form-label">Nome</label>
                    <input name="name" class="form-input" required>
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="form-label">SLA (horas)</label>
                        <input name="response_sla_hours" type="number" min="1" value="24" class="form-input" required>
                    </div>
                    <div>
                        <label class="form-label">Intervalo (dias)</label>
                        <input name="followup_interval_days" type="number" min="1" value="3" class="form-input" required>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="form-label">Escalação (dias)</label>
                        <input name="escalation_threshold_days" type="number" min="1" value="2" class="form-input">
                    </div>
                    <div>
                        <label class="form-label">Prioridade</label>
                        <input name="priority" type="number" min="0" value="10" class="form-input" required>
                    </div>
                </div>
                <input type="hidden" name="warning_hours_before" value="4">
                <label class="inline-flex items-center gap-2 text-sm text-slate-300">
                    <input type="checkbox" name="active" value="1" checked>
                    Ativo
                </label>
                <button class="btn-primary">Salvar SLA</button>
            </form>
        </div>

        <div class="card">
            <h2 class="text-lg font-semibold text-slate-100 mb-4">Nova Regra</h2>
            <form method="POST" action="<?php echo e(route('followups.settings.rules.store')); ?>" class="space-y-3">
                <?php echo csrf_field(); ?>
                <div>
                    <label class="form-label">Pipeline</label>
                    <select name="pipeline_id" class="form-input" required>
                        <?php $__currentLoopData = $pipelines; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pipeline): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($pipeline->id); ?>"><?php echo e($pipeline->name); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div>
                    <label class="form-label">Regra</label>
                    <input name="name" class="form-input" required>
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="form-label">Trigger</label>
                        <input name="trigger_type" value="days_without_activity" class="form-input" required>
                    </div>
                    <div>
                        <label class="form-label">Valor</label>
                        <input name="trigger_value" value="3" class="form-input" required>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="form-label">Ação</label>
                        <input name="action_type" value="create_activity" class="form-input" required>
                    </div>
                    <div>
                        <label class="form-label">Tipo atividade</label>
                        <input name="activity_type" value="task" class="form-input">
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="form-label">Ordem</label>
                        <input type="number" min="0" name="order" value="1" class="form-input" required>
                    </div>
                    <div>
                        <label class="form-label">Cooldown (h)</label>
                        <input type="number" min="0" name="cooldown_hours" value="24" class="form-input" required>
                    </div>
                </div>
                <label class="inline-flex items-center gap-2 text-sm text-slate-300">
                    <input type="checkbox" name="only_if_no_recent_activity" value="1" checked>
                    Apenas sem atividade recente
                </label>
                <label class="inline-flex items-center gap-2 text-sm text-slate-300 ml-4">
                    <input type="checkbox" name="active" value="1" checked>
                    Ativa
                </label>
                <button class="btn-primary">Salvar Regra</button>
            </form>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mt-6">
        <div class="card">
            <h3 class="text-sm font-semibold text-slate-200 mb-3">SLAs Cadastrados</h3>
            <div class="space-y-2 text-sm text-slate-300">
                <?php $__empty_1 = true; $__currentLoopData = $slas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sla): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="border border-bg-border rounded p-2"><?php echo e($sla->name); ?> - <?php echo e($sla->pipeline?->name); ?></div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <div class="text-slate-500">Nenhum SLA cadastrado.</div>
                <?php endif; ?>
            </div>
        </div>
        <div class="card">
            <h3 class="text-sm font-semibold text-slate-200 mb-3">Regras Cadastradas</h3>
            <div class="space-y-2 text-sm text-slate-300">
                <?php $__empty_1 = true; $__currentLoopData = $rules; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rule): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="border border-bg-border rounded p-2"><?php echo e($rule->name); ?> - <?php echo e($rule->pipeline?->name); ?></div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <div class="text-slate-500">Nenhuma regra cadastrada.</div>
                <?php endif; ?>
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
<?php /**PATH /var/www/html/resources/views/deals/followups/settings.blade.php ENDPATH**/ ?>