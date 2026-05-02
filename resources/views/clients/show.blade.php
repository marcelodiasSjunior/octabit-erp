@php
    $isLeads = $client->status === \App\Enums\ClientStatus::Lead;
    $sectionLabel = $isLeads ? 'Leads' : 'Clientes';
@endphp

<x-layouts.app :title="$client->name" :header="$sectionLabel . ' / ' . $client->name">

    <div id="show-client-container" class="max-w-5xl space-y-6">

        @if(session('success'))
            <div id="flash-success" class="px-4 py-3 rounded-lg bg-green-500/10 border border-green-500/30 text-green-400 text-sm">
                {{ session('success') }}
            </div>
        @endif

        {{-- ── Header ─────────────────────────────────────────────────── --}}
        <div id="client-header-card" class="card flex flex-col sm:flex-row sm:items-center gap-4">
            <div id="client-avatar" class="flex-shrink-0 w-14 h-14 rounded-xl bg-octa-500/10 border border-octa-500/20
                        flex items-center justify-center">
                <span class="text-xl font-bold text-octa-400">
                    {{ strtoupper(substr($client->name, 0, 2)) }}
                </span>
            </div>
            <div class="flex-1 min-w-0">
                <div class="flex flex-wrap items-center gap-3">
                    <h1 id="client-name-title" class="text-lg font-bold text-slate-100">{{ $client->name }}</h1>
                    <x-status-badge :status="$client->status"/>
                </div>
                @if($client->company_name)
                    <p id="client-company-subtitle" class="text-sm text-slate-400 mt-0.5">{{ $client->company_name }}</p>
                @endif
            </div>
            <div id="client-actions-header" class="flex gap-2 flex-shrink-0">
                <a id="btn-edit-client" href="{{ route('clients.edit', ['client' => $client, 'segment' => $isLeads ? 'leads' : 'clients']) }}" class="btn-secondary btn-sm">Editar</a>
            </div>
        </div>

        {{-- ── Info + Address ─────────────────────────────────────────── --}}
        <div id="client-info-grid" class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <div id="client-details-card" class="card space-y-4">
                <h2 class="text-sm font-semibold text-slate-300 uppercase tracking-wider">Informações</h2>
                <div>
                    <p class="text-xs text-slate-500">CPF / CNPJ</p>
                    <p id="client-document-display" class="text-sm font-mono text-slate-200">{{ $client->formatted_document }}</p>
                </div>
                <div>
                    <p class="text-xs text-slate-500">E-mail</p>
                    <a id="link-client-email" href="mailto:{{ $client->email }}"
                       class="text-sm text-octa-400 hover:text-octa-300 transition-colors">{{ $client->email }}</a>
                </div>
                <div>
                    <p class="text-xs text-slate-500">Telefone</p>
                    <p id="client-phone-display" class="text-sm text-slate-200">{{ $client->phone ?? '—' }}</p>
                </div>
                <div>
                    <p class="text-xs text-slate-500">Cliente desde</p>
                    <p id="client-created-at" class="text-sm text-slate-200">{{ $client->created_at->format('d/m/Y') }}</p>
                </div>
            </div>

            <div id="client-address-card" class="card space-y-4">
                <h2 class="text-sm font-semibold text-slate-300 uppercase tracking-wider">Endereço</h2>
                @if($client->address || $client->city)
                    @if($client->address)
                        <div>
                            <p class="text-xs text-slate-500">Logradouro</p>
                            <p id="client-address-display" class="text-sm text-slate-200">{{ $client->address }}</p>
                        </div>
                    @endif
                    @if($client->city || $client->state)
                        <div>
                            <p class="text-xs text-slate-500">Cidade / UF</p>
                            <p id="client-location-display" class="text-sm text-slate-200">
                                {{ implode(' — ', array_filter([$client->city, $client->state])) }}
                            </p>
                        </div>
                    @endif
                    @if($client->zip_code)
                        <div>
                            <p class="text-xs text-slate-500">CEP</p>
                            <p id="client-zip-display" class="text-sm text-slate-200">{{ $client->zip_code }}</p>
                        </div>
                    @endif
                @else
                    <p class="text-sm text-slate-500">Nenhum endereço cadastrado.
                        <a id="link-add-address" href="{{ route('clients.edit', $client) }}" class="text-octa-400 hover:underline">Adicionar →</a>
                    </p>
                @endif

                @if($client->notes)
                    <div id="client-notes-section" class="pt-2 border-t border-bg-border">
                        <p class="text-xs text-slate-500">Observações</p>
                        <p id="client-notes-display" class="text-sm text-slate-400 leading-relaxed mt-1">{{ $client->notes }}</p>
                    </div>
                @endif
            </div>
        </div>

        {{-- ── Serviços Contratados ─────────────────────────────────────── --}}
        <div id="client-services-card" class="card">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-sm font-semibold text-slate-300 uppercase tracking-wider">Serviços Contratados</h2>
            </div>

            @if($client->clientServices->isNotEmpty())
                <div id="client-services-list" class="space-y-2 mb-4">
                    @foreach($client->clientServices as $cs)
                        <div id="client-service-item-{{ $cs->id }}" class="flex items-center gap-3 py-2 border-b border-bg-border/50 last:border-0">
                            <div class="flex-1 min-w-0">
                                <p id="client-service-name-{{ $cs->id }}" class="text-sm font-medium text-slate-200">{{ $cs->service->name }}</p>
                                <p class="text-xs text-slate-500">
                                    Início: {{ $cs->start_date->format('d/m/Y') }}
                                    @if($cs->end_date) · Fim: {{ $cs->end_date->format('d/m/Y') }} @endif
                                </p>
                            </div>
                            <div class="text-right flex-shrink-0">
                                <p id="client-service-price-{{ $cs->id }}" class="text-sm font-semibold text-slate-200">
                                    R$ {{ number_format($cs->effective_price, 2, ',', '.') }}/mês
                                </p>
                                <x-status-badge :status="$cs->status"/>
                            </div>
                            <form id="delete-client-service-form-{{ $cs->id }}" method="POST"
                                  action="{{ route('clients.services.destroy', [$client->id, $cs->id]) }}"
                                  x-data @submit.prevent="$dispatch('dialog', { 
                                      title: 'Remover Vínculo', 
                                      message: 'Deseja realmente remover o vínculo deste serviço?',
                                      type: 'danger',
                                      onConfirm: () => $el.submit()
                                  })">
                                @csrf @method('DELETE')
                                <button id="btn-delete-client-service-{{ $cs->id }}" type="submit" class="text-slate-600 hover:text-red-400 transition-colors p-1 rounded">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    @endforeach
                </div>
            @endif

            @if($availableServices->isNotEmpty())
                <details id="details-add-service" class="group">
                    <summary id="summary-add-service" class="cursor-pointer text-sm text-octa-400 hover:text-octa-300 select-none list-none flex items-center gap-1">
                        <svg class="w-4 h-4 group-open:rotate-45 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        Vincular serviço
                    </summary>
                    <form id="form-add-client-service" method="POST"
                          action="{{ route('clients.services.store', $client->id) }}"
                          class="mt-3 grid grid-cols-1 sm:grid-cols-3 gap-3 p-3 rounded-lg bg-bg-input border border-bg-border">
                        @csrf
                        <div class="sm:col-span-3">
                            <label class="label text-xs">Serviço</label>
                            <select id="select-service-id" name="service_id" class="ajax-select" required>
                                <option value="">Selecione...</option>
                                @foreach($availableServices as $svc)
                                    <option value="{{ $svc->id }}">{{ $svc->name }} — R$ {{ number_format($svc->base_price, 2, ',', '.') }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="label text-xs">Preço personalizado</label>
                            <input id="input-service-price" type="number" name="custom_price" step="0.01" min="0" placeholder="Padrão do serviço" class="input text-sm"/>
                        </div>
                        <div>
                            <label class="label text-xs">Início <span class="text-red-500">*</span></label>
                            <input id="input-service-start-date" type="date" name="start_date" value="{{ now()->toDateString() }}" class="input text-sm" required/>
                        </div>
                        <div>
                            <label class="label text-xs">Término</label>
                            <input id="input-service-end-date" type="date" name="end_date" class="input text-sm"/>
                        </div>
                        <input type="hidden" name="status" value="active"/>
                        <div class="sm:col-span-3 flex justify-end">
                            <button id="btn-save-client-service" type="submit" class="btn-primary btn-sm">Vincular</button>
                        </div>
                    </form>
                </details>
            @endif
        </div>

        {{-- ── Produtos ────────────────────────────────────────────────── --}}
        <div id="client-products-card" class="card">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-sm font-semibold text-slate-300 uppercase tracking-wider">Produtos Comprados</h2>
            </div>

            @if($client->clientProducts->isNotEmpty())
                <div id="client-products-list" class="space-y-2 mb-4">
                    @foreach($client->clientProducts->sortByDesc('purchased_at') as $cp)
                        <div id="client-product-item-{{ $cp->id }}" class="flex items-center gap-3 py-2 border-b border-bg-border/50 last:border-0">
                            <div class="flex-1 min-w-0">
                                <p id="client-product-name-{{ $cp->id }}" class="text-sm font-medium text-slate-200">{{ $cp->product->name }}</p>
                                <p class="text-xs text-slate-500">
                                    {{ $cp->purchased_at->format('d/m/Y') }} · Qtd: {{ $cp->quantity }}
                                    @if($cp->notes) · {{ $cp->notes }} @endif
                                </p>
                            </div>
                            <div class="text-right flex-shrink-0">
                                <p id="client-product-total-{{ $cp->id }}" class="text-sm font-semibold text-slate-200">R$ {{ number_format($cp->total, 2, ',', '.') }}</p>
                                <p class="text-xs text-slate-500">R$ {{ number_format($cp->effective_price, 2, ',', '.') }} / un</p>
                            </div>
                            <form id="delete-client-product-form-{{ $cp->id }}" method="POST"
                                  action="{{ route('clients.products.destroy', [$client->id, $cp->id]) }}"
                                  x-data @submit.prevent="$dispatch('dialog', { 
                                      title: 'Remover Registro', 
                                      message: 'Deseja realmente excluir este registro de compra?',
                                      type: 'danger',
                                      onConfirm: () => $el.submit()
                                  })">
                                @csrf @method('DELETE')
                                <button id="btn-delete-client-product-{{ $cp->id }}" type="submit" class="text-slate-600 hover:text-red-400 transition-colors p-1 rounded">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    @endforeach
                </div>
            @endif

            @if($availableProducts->isNotEmpty())
                <details id="details-add-product" class="group">
                    <summary id="summary-add-product" class="cursor-pointer text-sm text-octa-400 hover:text-octa-300 select-none list-none flex items-center gap-1">
                        <svg class="w-4 h-4 group-open:rotate-45 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        Registrar produto
                    </summary>
                    <form id="form-add-client-product" method="POST"
                          action="{{ route('clients.products.store', $client->id) }}"
                          class="mt-3 grid grid-cols-1 sm:grid-cols-4 gap-3 p-3 rounded-lg bg-bg-input border border-bg-border">
                        @csrf
                        <div class="sm:col-span-4">
                            <label class="label text-xs">Produto</label>
                            <select id="select-product-id" name="product_id" class="ajax-select" required>
                                <option value="">Selecione...</option>
                                @foreach($availableProducts as $prod)
                                    <option value="{{ $prod->id }}">{{ $prod->name }} — R$ {{ number_format($prod->price, 2, ',', '.') }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="label text-xs">Qtd <span class="text-red-500">*</span></label>
                            <input id="input-product-quantity" type="number" name="quantity" value="1" min="1" max="9999" class="input text-sm" required/>
                        </div>
                        <div>
                            <label class="label text-xs">Preço unitário</label>
                            <input id="input-product-price" type="number" name="unit_price" step="0.01" min="0" placeholder="Padrão" class="input text-sm"/>
                        </div>
                        <div>
                            <label class="label text-xs">Data <span class="text-red-500">*</span></label>
                            <input id="input-product-date" type="date" name="purchased_at" value="{{ now()->toDateString() }}" class="input text-sm" required/>
                        </div>
                        <div>
                            <label class="label text-xs">Observação</label>
                            <input id="input-product-notes" type="text" name="notes" placeholder="Opcional" class="input text-sm" maxlength="500"/>
                        </div>
                        <div class="sm:col-span-4 flex justify-end">
                            <button id="btn-save-client-product" type="submit" class="btn-primary btn-sm">Registrar</button>
                        </div>
                    </form>
                </details>
            @endif
        </div>

        {{-- ── Contratos ────────────────────────────────────────────────── --}}
        <div id="client-contracts-card" class="card">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-sm font-semibold text-slate-300 uppercase tracking-wider">Contratos</h2>
                <a id="link-create-contract" href="{{ route('contracts.create') }}" class="text-xs text-octa-400 hover:text-octa-300 transition-colors">+ Novo →</a>
            </div>

            @if($client->contracts->isNotEmpty())
                <div id="client-contracts-list" class="space-y-2">
                    @foreach($client->contracts->sortByDesc('start_date') as $contract)
                        <div id="client-contract-item-{{ $contract->id }}" class="flex items-center gap-3 py-2 border-b border-bg-border/50 last:border-0">
                            <div class="flex-1 min-w-0">
                                <a id="link-show-contract-{{ $contract->id }}" href="{{ route('contracts.show', $contract) }}"
                                   class="text-sm font-medium text-octa-400 hover:text-octa-300">
                                    Contrato #{{ $contract->id }}
                                </a>
                                <p class="text-xs text-slate-500">
                                    {{ $contract->start_date->format('d/m/Y') }}
                                    @if($contract->end_date) → {{ $contract->end_date->format('d/m/Y') }} @endif
                                </p>
                            </div>
                            <div class="text-right flex-shrink-0">
                                <p id="client-contract-value-{{ $contract->id }}" class="text-sm font-semibold text-slate-200">R$ {{ number_format($contract->value, 2, ',', '.') }}</p>
                                <x-status-badge :status="$contract->status"/>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p id="no-contracts-msg" class="text-sm text-slate-500 text-center py-4">Nenhum contrato.
                    <a id="link-create-first-contract" href="{{ route('contracts.create') }}" class="text-octa-400 hover:underline">Criar →</a>
                </p>
            @endif
        </div>

        {{-- ── Cobranças ────────────────────────────────────────────────── --}}
        <div id="client-receivables-card" class="card">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-sm font-semibold text-slate-300 uppercase tracking-wider">Cobranças Recentes</h2>
                <a id="link-view-all-receivables" href="{{ route('receivable.index', ['client_id' => $client->id]) }}"
                   class="text-xs text-octa-400 hover:text-octa-300 transition-colors">Ver todas →</a>
            </div>

            @php
                $receivables = $client->accountsReceivable()->latest('due_date')->take(5)->get();
            @endphp

            @if($receivables->isEmpty())
                <p id="no-receivables-msg" class="text-sm text-slate-500 text-center py-4">Nenhuma cobrança cadastrada.</p>
            @else
                <div id="client-receivables-list" class="space-y-2">
                    @foreach($receivables as $ar)
                        <div id="receivable-item-{{ $ar->id }}" class="flex items-center gap-3 py-2 border-b border-bg-border/50 last:border-0">
                            <div class="flex-1 min-w-0">
                                <p id="receivable-desc-{{ $ar->id }}" class="text-sm text-slate-200 truncate">{{ $ar->description }}</p>
                                <p class="text-xs text-slate-500">Vencimento: {{ $ar->due_date->format('d/m/Y') }}</p>
                            </div>
                            <div class="text-right flex-shrink-0">
                                <p id="receivable-amount-{{ $ar->id }}" class="text-sm font-semibold text-slate-200">R$ {{ number_format($ar->amount, 2, ',', '.') }}</p>
                                <x-status-badge :status="$ar->status"/>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        {{-- ── Timeline de Interações ───────────────────────────────────── --}}
        <div id="client-interactions-card" class="card">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-sm font-semibold text-slate-300 uppercase tracking-wider">Histórico de Interações</h2>
            </div>

            @if($client->interactions->isNotEmpty())
                <div id="client-interactions-list" class="space-y-3 mb-6">
                    @foreach($client->interactions->sortByDesc('occurred_at') as $interaction)
                        <div id="interaction-item-{{ $interaction->id }}" class="flex gap-3">
                            <div class="flex-shrink-0 w-8 h-8 rounded-full flex items-center justify-center {{ $interaction->type->color() }}">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $interaction->type->icon() }}"/>
                                </svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="flex items-start justify-between gap-2">
                                    <div>
                                        <span class="text-xs font-semibold text-slate-400 uppercase">{{ $interaction->type->label() }}</span>
                                        <span class="text-xs text-slate-600 ml-2">
                                            {{ $interaction->occurred_at->format('d/m/Y H:i') }} · {{ $interaction->user->name ?? 'Sistema' }}
                                        </span>
                                    </div>
                                    <form id="delete-interaction-form-{{ $interaction->id }}" method="POST"
                                          action="{{ route('clients.interactions.destroy', [$client->id, $interaction->id]) }}"
                                          x-data @submit.prevent="$dispatch('dialog', { 
                                              title: 'Remover Interação', 
                                              message: 'Deseja realmente excluir esta interação do histórico?',
                                              type: 'danger',
                                              onConfirm: () => $el.submit()
                                          })">
                                        @csrf @method('DELETE')
                                        <button id="btn-delete-interaction-{{ $interaction->id }}" type="submit" class="text-slate-700 hover:text-red-400 transition-colors flex-shrink-0">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                                <p id="interaction-desc-{{ $interaction->id }}" class="text-sm text-slate-300 mt-0.5 leading-relaxed">{{ $interaction->description }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

            <details id="details-add-interaction" class="group" @if($client->interactions->isEmpty()) open @endif>
                <summary id="summary-add-interaction" class="cursor-pointer text-sm text-octa-400 hover:text-octa-300 select-none list-none flex items-center gap-1">
                    <svg class="w-4 h-4 group-open:rotate-45 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Registrar interação
                </summary>
                <form id="form-add-interaction" method="POST"
                      action="{{ route('clients.interactions.store', $client->id) }}"
                      class="mt-3 grid grid-cols-1 sm:grid-cols-3 gap-3 p-3 rounded-lg bg-bg-input border border-bg-border">
                    @csrf
                    <div>
                        <label class="label text-xs">Tipo <span class="text-red-500">*</span></label>
                        <select id="select-interaction-type" name="type" class="ajax-select" required>
                            @foreach(\App\Enums\InteractionType::cases() as $type)
                                <option value="{{ $type->value }}">{{ $type->label() }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="label text-xs">Data / hora <span class="text-red-500">*</span></label>
                        <input id="input-interaction-date" type="datetime-local" name="occurred_at"
                               value="{{ now()->format('Y-m-d\TH:i') }}"
                               class="input text-sm" required/>
                    </div>
                    <div class="sm:col-span-3">
                        <label class="label text-xs">Descrição <span class="text-red-500">*</span></label>
                        <textarea id="textarea-interaction-desc" name="description" rows="2" class="input resize-none" required
                                  placeholder="Descreva a interação..."></textarea>
                    </div>
                    <div class="sm:col-span-3 flex justify-end">
                        <button id="btn-save-interaction" type="submit" class="btn-primary btn-sm">Registrar</button>
                    </div>
                </form>
            </details>
        </div>

        <a id="btn-back-clients" href="{{ route('clients.index') }}" class="btn-ghost inline-block">← Voltar</a>
    </div>

</x-layouts.app>

