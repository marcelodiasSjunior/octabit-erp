<x-layouts.app title="Novo Orçamento" header="Orçamentos / Novo">

    <div class="max-w-5xl"
         x-data="{
            items: [{ description: '', quantity: 1, unit_price: '', discount: 0, product_id: '', service_id: '' }],
            {{-- ... (rest of x-data unchanged) ... --}}
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
                this.$nextTick(() => {
                    if (window.initTomSelect) window.initTomSelect();
                });
            },
            onSearchSelect(index, type, event) {
                const ts = event.target.tomselect;
                const data = ts.options[ts.getValue()];
                if (!data) return;

                this.items[index].description = data.text.split(' - ')[0];
                this.items[index].unit_price = data.price;
                if (type === 'product') {
                    this.items[index].product_id = data.id;
                    this.items[index].service_id = '';
                } else {
                    this.items[index].service_id = data.id;
                    this.items[index].product_id = '';
                }
                
                // Clear the search select
                ts.clear();
            },
            removeItem(index) {
                if (this.items.length > 1) this.items.splice(index, 1);
            },
            fmt(val) {
                return parseFloat(val || 0).toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' });
            }
         }">

        <form id="form-create-quote" method="POST" action="{{ route('quotes.store') }}">
            @csrf

            {{-- Header card --}}
            <div id="quote-header-card" class="card mb-4">
                <h2 class="text-base font-semibold text-slate-200 mb-6">Dados do Orçamento</h2>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    {{-- Client --}}
                    {{-- Client selector --}}
                    <div>
                        <label for="client_id" class="label">Cliente <span class="text-red-500">*</span></label>
                        <select id="client_id" name="client_id"
                                class="form-select ajax-select @error('client_id') input-error @enderror"
                                data-search-url="{{ route('search.clients') }}"
                                required>
                            <option value="">Buscar cliente...</option>
                            @if(old('client_id'))
                                @php $oldClient = \App\Models\Client::find(old('client_id')); @endphp
                                @if($oldClient)
                                    <option value="{{ $oldClient->id }}" selected>{{ $oldClient->display_name }}</option>
                                @endif
                            @endif
                        </select>
                        @error('client_id') <p class="form-error">{{ $message }}</p> @enderror
                    </div>


                    {{-- Valid until --}}
                    <div>
                        <label for="valid_until" class="label">Válido até <span class="text-red-500">*</span></label>
                        <input type="date" id="valid_until" name="valid_until"
                               value="{{ old('valid_until') }}"
                               min="{{ now()->addDay()->format('Y-m-d') }}"
                               class="input @error('valid_until') input-error @enderror" required/>
                        @error('valid_until') <p class="form-error">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>

            {{-- Items card --}}
            <div id="quote-items-card" class="card mb-4">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-base font-semibold text-slate-200">Itens</h2>
                    <button id="btn-add-item" type="button" @click="addItem()"
                            class="btn-ghost btn-sm gap-1.5">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        Adicionar item
                    </button>
                </div>

                {{-- Validation error for items --}}
                @error('items') <p id="error-items" class="form-error mb-3">{{ $message }}</p> @enderror

                <div id="quote-items-list" class="space-y-3">
                    <template x-for="(item, index) in items" :key="index">
                        <div :id="`item-row-${index}`" class="border border-bg-border rounded-lg p-4 bg-bg-primary/40">
                            {{-- Autocomplete de Produto/Serviço --}}
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4 pb-4 border-b border-bg-border/30">
                                <div>
                                    <label class="label text-[10px] uppercase text-slate-500">Buscar Produto</label>
                                    <select class="ajax-select" 
                                            data-search-url="{{ route('search.products') }}"
                                            @change="onSearchSelect(index, 'product', $event)">
                                        <option value="">Pesquisar produto...</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="label text-[10px] uppercase text-slate-500">Buscar Serviço</label>
                                    <select class="ajax-select" 
                                            data-search-url="{{ route('search.services') }}"
                                            @change="onSearchSelect(index, 'service', $event)">
                                        <option value="">Pesquisar serviço...</option>
                                    </select>
                                </div>
                            </div>

                            <div class="grid grid-cols-12 gap-3">
                                {{-- Description --}}
                                <div class="col-span-12 sm:col-span-4">
                                    <label class="label text-xs">Descrição *</label>
                                    <input type="text"
                                           :id="`item-description-${index}`"
                                           :name="`items[${index}][description]`"
                                           x-model="item.description"
                                           placeholder="Descrição do item"
                                           class="input text-sm" required/>
                                </div>

                                {{-- Qty --}}
                                <div class="col-span-6 sm:col-span-1">
                                    <label class="label text-xs">Qtd *</label>
                                    <input type="number"
                                           :id="`item-quantity-${index}`"
                                           :name="`items[${index}][quantity]`"
                                           x-model="item.quantity"
                                           min="0.0001" step="any"
                                           class="input text-sm px-2 text-center" required/>
                                </div>

                                {{-- Unit price --}}
                                <div class="col-span-6 sm:col-span-2">
                                    <label class="label text-xs">Preço unit. *</label>
                                    <input type="number"
                                           :id="`item-unit-price-${index}`"
                                           :name="`items[${index}][unit_price]`"
                                           x-model="item.unit_price"
                                           min="0" step="any"
                                           placeholder="0,00"
                                           class="input text-sm" required/>
                                </div>

                                {{-- Discount R$ --}}
                                <div class="col-span-6 sm:col-span-2">
                                    <label class="label text-xs">Desc. R$</label>
                                    <input type="number"
                                           :id="`item-discount-${index}`"
                                           :name="`items[${index}][discount]`"
                                           x-model="item.discount"
                                           min="0" step="any"
                                           placeholder="0,00"
                                           class="input text-sm"/>
                                </div>

                                {{-- Line total + remove --}}
                                <div class="col-span-6 sm:col-span-3 flex items-center justify-end gap-3 pt-5 border-l border-bg-border/50 pl-3">
                                    <div class="text-right">
                                        <p class="text-[10px] text-slate-500 uppercase tracking-widest leading-none mb-1">Total Item</p>
                                        <span :id="`item-total-${index}`"
                                              class="text-sm font-semibold text-octa-300 whitespace-nowrap"
                                              x-text="fmt(lineTotal(item))"></span>
                                    </div>
                                    <button :id="`btn-remove-item-${index}`" type="button" @click="removeItem(index)"
                                            x-show="items.length > 1"
                                            class="text-slate-600 hover:text-red-400 transition-colors p-1" title="Remover">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                    </button>
                                </div>

                                {{-- Hidden product/service ids --}}
                                <input type="hidden" :name="`items[${index}][product_id]`" :value="item.product_id || ''"/>
                                <input type="hidden" :name="`items[${index}][service_id]`" :value="item.service_id || ''"/>
                            </div>
                        </div>
                    </template>
                </div>

                {{-- Totals --}}
                <div id="quote-totals" class="mt-6 flex flex-col items-end gap-1 text-sm border-t border-bg-border pt-4">
                    <div class="flex gap-6 text-slate-400">
                        <span>Subtotal</span>
                        <span id="quote-subtotal" x-text="fmt(subtotal)" class="w-32 text-right"></span>
                    </div>
                    <div class="flex gap-6 text-slate-400">
                        <span>Descontos</span>
                        <span id="quote-discount-total" x-text="'- ' + fmt(discountTotal)" class="w-32 text-right text-red-400"></span>
                    </div>
                    <div class="flex gap-6 text-slate-100 font-semibold text-base mt-1">
                        <span>Total Geral</span>
                        <span id="quote-total" x-text="fmt(total)" class="w-32 text-right text-octa-300"></span>
                    </div>
                </div>
            </div>

            {{-- Actions --}}
            <div id="quote-actions" class="flex gap-3">
                <button id="btn-save-quote" type="submit" class="btn-primary">Salvar rascunho</button>
                <a id="btn-cancel-quote" href="{{ route('quotes.index') }}" class="btn-ghost">Cancelar</a>
            </div>
        </form>
    </div>

</x-layouts.app>
