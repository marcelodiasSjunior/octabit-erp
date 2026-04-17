<?php if (isset($component)) { $__componentOriginal5863877a5171c196453bfa0bd807e410 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5863877a5171c196453bfa0bd807e410 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.layouts.app','data' => ['title' => 'Editar Orçamento #'.e($quote->id).'','header' => 'Orçamentos / Editar #'.e($quote->id).'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.app'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Editar Orçamento #'.e($quote->id).'','header' => 'Orçamentos / Editar #'.e($quote->id).'']); ?>

    <div class="max-w-4xl"
         x-data="{
            items: <?php echo e(Js::from($quote->items->map(fn($i) => [
                'description' => $i->description,
                'quantity'    => (float) $i->quantity,
                'unit_price'  => (float) $i->unit_price,
                'discount'    => (float) $i->discount,
                'product_id'  => $i->product_id ?? '',
                'service_id'  => $i->service_id ?? '',
            ]))); ?>,
            get subtotal() {
                return this.items.reduce((sum, item) => {
                    return sum + (parseFloat(item.quantity || 0) * parseFloat(item.unit_price || 0));
                }, 0);
            },
            get discountTotal() {
                return this.items.reduce((sum, item) => {
                    return sum + parseFloat(item.discount || 0);
                }, 0);
            },
            get total() { return this.subtotal - this.discountTotal; },
            lineTotal(item) {
                const sub = parseFloat(item.quantity || 0) * parseFloat(item.unit_price || 0);
                return sub - parseFloat(item.discount || 0);
            },
            addItem() {
                this.items.push({ description: '', quantity: 1, unit_price: '', discount: 0, product_id: '', service_id: '' });
            },
            removeItem(index) {
                if (this.items.length > 1) this.items.splice(index, 1);
            },
            fmt(val) {
                return parseFloat(val || 0).toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' });
            }
         }">

        <form method="POST" action="<?php echo e(route('quotes.update', $quote->id)); ?>">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>

            
            <div class="card mb-4">
                <h2 class="text-base font-semibold text-slate-200 mb-6">Dados do Orçamento</h2>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    
                    <div class="sm:col-span-2">
                        <label for="client_id" class="label">Cliente <span class="text-red-500">*</span></label>
                        <select id="client_id" name="client_id"
                                class="select <?php $__errorArgs = ['client_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> input-error <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                            <option value="">Selecione um cliente...</option>
                            <?php $__currentLoopData = $clients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $client): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($client->id); ?>"
                                    <?php echo e((old('client_id', $quote->client_id) == $client->id) ? 'selected' : ''); ?>>
                                    <?php echo e($client->name); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                        <?php $__errorArgs = ['client_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="form-error"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    
                    <div>
                        <label for="valid_until" class="label">Válido até <span class="text-red-500">*</span></label>
                        <input type="date" id="valid_until" name="valid_until"
                               value="<?php echo e(old('valid_until', $quote->valid_until?->format('Y-m-d'))); ?>"
                               class="input <?php $__errorArgs = ['valid_until'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> input-error <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required/>
                        <?php $__errorArgs = ['valid_until'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="form-error"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                </div>
            </div>

            
            <div class="card mb-4">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-base font-semibold text-slate-200">Itens</h2>
                    <button type="button" @click="addItem()"
                            class="btn-ghost btn-sm gap-1.5">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        Adicionar item
                    </button>
                </div>

                <?php $__errorArgs = ['items'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="form-error mb-3"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

                <div class="space-y-3">
                    <template x-for="(item, index) in items" :key="index">
                        <div class="border border-bg-border rounded-lg p-4 bg-bg-primary/40">
                            <div class="grid grid-cols-12 gap-3">
                                <div class="col-span-12 sm:col-span-5">
                                    <label class="label text-xs">Descrição *</label>
                                    <input type="text"
                                           :name="`items[${index}][description]`"
                                           x-model="item.description"
                                           placeholder="Descrição do item"
                                           class="input text-sm" required/>
                                </div>
                                <div class="col-span-4 sm:col-span-2">
                                    <label class="label text-xs">Qtd *</label>
                                    <input type="number"
                                           :name="`items[${index}][quantity]`"
                                           x-model="item.quantity"
                                           min="0.0001" step="0.01"
                                           class="input text-sm" required/>
                                </div>
                                <div class="col-span-4 sm:col-span-2">
                                    <label class="label text-xs">Preço unit. *</label>
                                    <input type="number"
                                           :name="`items[${index}][unit_price]`"
                                           x-model="item.unit_price"
                                           min="0" step="0.01"
                                           placeholder="0,00"
                                           class="input text-sm" required/>
                                </div>
                                <div class="col-span-4 sm:col-span-2">
                                    <label class="label text-xs">Desc. R$</label>
                                    <input type="number"
                                           :name="`items[${index}][discount]`"
                                           x-model="item.discount"
                                           min="0" step="0.01"
                                           placeholder="0,00"
                                           class="input text-sm"/>
                                </div>
                                <div class="col-span-12 sm:col-span-1 flex sm:flex-col items-end sm:items-end justify-between sm:justify-start gap-2 pt-0 sm:pt-5">
                                    <span class="text-sm font-semibold text-octa-300"
                                          x-text="fmt(lineTotal(item))"></span>
                                    <button type="button" @click="removeItem(index)"
                                            x-show="items.length > 1"
                                            class="text-slate-600 hover:text-red-400 transition-colors" title="Remover">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                    </button>
                                </div>
                                <input type="hidden" :name="`items[${index}][product_id]`" :value="item.product_id || ''"/>
                                <input type="hidden" :name="`items[${index}][service_id]`" :value="item.service_id || ''"/>
                            </div>
                        </div>
                    </template>
                </div>

                <div class="mt-6 flex flex-col items-end gap-1 text-sm border-t border-bg-border pt-4">
                    <div class="flex gap-6 text-slate-400">
                        <span>Subtotal</span>
                        <span x-text="fmt(subtotal)" class="w-28 text-right"></span>
                    </div>
                    <div class="flex gap-6 text-slate-400">
                        <span>Descontos</span>
                        <span x-text="'- ' + fmt(discountTotal)" class="w-28 text-right text-red-400"></span>
                    </div>
                    <div class="flex gap-6 text-slate-100 font-semibold text-base mt-1">
                        <span>Total</span>
                        <span x-text="fmt(total)" class="w-28 text-right text-octa-300"></span>
                    </div>
                </div>
            </div>

            
            <div class="flex gap-3">
                <button type="submit" class="btn-primary">Salvar alterações</button>
                <a href="<?php echo e(route('quotes.show', $quote->id)); ?>" class="btn-ghost">Cancelar</a>
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
<?php /**PATH /var/www/html/resources/views/quotes/edit.blade.php ENDPATH**/ ?>