<x-layouts.app :title="$deal->title" header="Detalhe da Oportunidade">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- ── Left: info + atividades ──────────────────────── --}}
        <div class="lg:col-span-2 space-y-6">
            <div class="card">
                <h2 class="text-lg font-semibold text-slate-100">{{ $deal->title }}</h2>
                @if($deal->notes)
                    <p class="text-slate-400 mt-2 text-sm">{{ $deal->notes }}</p>
                @endif

                <dl class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-6 text-sm">
                    <div>
                        <dt class="text-slate-500">Cliente</dt>
                        <dd class="text-slate-200">{{ $deal->client->display_name }}</dd>
                    </div>
                    <div>
                        <dt class="text-slate-500">Pipeline</dt>
                        <dd class="text-slate-200">{{ $deal->pipeline->name }}</dd>
                    </div>
                    <div>
                        <dt class="text-slate-500">Etapa</dt>
                        <dd class="text-slate-200">{{ $deal->stage->name }}</dd>
                    </div>
                    <div>
                        <dt class="text-slate-500">Status</dt>
                        <dd class="text-slate-200">{{ $deal->status->label() }}</dd>
                    </div>
                    <div>
                        <dt class="text-slate-500">Valor</dt>
                        <dd class="text-slate-200 font-semibold">R$ {{ number_format((float) $deal->value, 2, ',', '.') }}</dd>
                    </div>
                    <div>
                        <dt class="text-slate-500">Previsão de Fechamento</dt>
                        <dd class="text-slate-200">{{ optional($deal->expected_close_date)->format('d/m/Y') ?? '—' }}</dd>
                    </div>
                </dl>
            </div>

            {{-- Atividades --}}
            <div class="card">
                <h3 class="text-sm font-semibold text-slate-200 mb-4">Atividades</h3>

                @forelse($deal->activities as $activity)
                    <div class="flex items-start gap-3 py-3 border-b border-bg-border/50 last:border-0">
                        <div class="mt-0.5">
                            @if($activity->done)
                                <span class="w-5 h-5 rounded-full bg-emerald-500/20 border border-emerald-500/40 flex items-center justify-center">
                                    <svg class="w-3 h-3 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                    </svg>
                                </span>
                            @elseif($activity->scheduled_at->isPast())
                                <span class="w-5 h-5 rounded-full bg-red-500/20 border border-red-500/40 block"></span>
                            @else
                                <span class="w-5 h-5 rounded-full bg-bg-elevated border border-bg-border block"></span>
                            @endif
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-slate-200 {{ $activity->done ? 'line-through text-slate-500' : '' }}">
                                {{ $activity->title }}
                            </p>
                            <p class="text-xs text-slate-500 mt-0.5">
                                {{ $activity->type->label() }} · {{ $activity->scheduled_at->format('d/m/Y H:i') }}
                                @if($activity->user) · {{ $activity->user->name }} @endif
                            </p>
                            @if($activity->notes)
                                <p class="text-xs text-slate-400 mt-1">{{ $activity->notes }}</p>
                            @endif
                        </div>
                        <div class="flex items-center gap-2 shrink-0">
                            @unless($activity->done)
                                <form id="complete-activity-form-{{ $activity->id }}" method="POST" action="{{ route('deals.activities.complete', [$deal, $activity]) }}">
                                    @csrf @method('PATCH')
                                    <button id="btn-complete-activity-{{ $activity->id }}" type="submit" class="text-xs text-emerald-400 hover:text-emerald-300">Concluir</button>
                                </form>
                            @endunless
                            <form id="delete-activity-form-{{ $activity->id }}" method="POST" action="{{ route('deals.activities.destroy', [$deal, $activity]) }}"
                                  x-data @submit.prevent="$dispatch('dialog', { 
                                      title: 'Remover Atividade', 
                                      message: 'Deseja realmente remover esta atividade?',
                                      type: 'danger',
                                      onConfirm: () => $el.submit()
                                  })">
                                @csrf @method('DELETE')
                                <button id="btn-delete-activity-{{ $activity->id }}" type="submit" class="text-xs text-slate-500 hover:text-red-400">Remover</button>
                            </form>
                        </div>
                    </div>
                @empty
                    <p class="text-slate-500 text-sm">Nenhuma atividade registrada.</p>
                @endforelse

                {{-- Nova atividade --}}
                <details id="details-new-activity" class="mt-4">
                    <summary id="summary-new-activity" class="cursor-pointer text-sm text-octa-400 hover:text-octa-300 font-medium">+ Nova atividade</summary>
                    <form id="form-add-activity" method="POST" action="{{ route('deals.activities.store', $deal) }}" class="mt-3 space-y-3">
                        @csrf
                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="label">Tipo</label>
                                <select id="select-activity-type" name="type" class="ajax-select" required>
                                    @foreach(\App\Enums\DealActivityType::cases() as $type)
                                        <option value="{{ $type->value }}">{{ $type->label() }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="label">Data/Hora</label>
                                <input id="input-activity-scheduled" name="scheduled_at" type="datetime-local" class="input" required />
                            </div>
                        </div>
                        <div>
                            <label class="label">Título</label>
                            <input id="input-activity-title" name="title" class="input" required />
                        </div>
                        <div>
                            <label class="label">Notas</label>
                            <textarea id="textarea-activity-notes" name="notes" class="input" rows="2"></textarea>
                        </div>
                        <button id="btn-save-activity" type="submit" class="btn-primary">Salvar Atividade</button>
                    </form>
                </details>
            </div>
        </div>

        {{-- ── Right: ações --}}
        <div class="space-y-4">
            <div class="card">
                <h3 class="text-sm font-semibold text-slate-200 mb-3">Mover Etapa</h3>
                <form id="form-move-stage" method="POST" action="{{ route('deals.move-stage', $deal) }}" class="space-y-3">
                    @csrf @method('PATCH')
                    <select id="select-move-stage" name="stage_id" class="ajax-select" required>
                        @foreach($deal->pipeline->stages as $stage)
                            <option value="{{ $stage->id }}" @selected($deal->stage_id === $stage->id)>
                                {{ $stage->name }} ({{ $stage->probability }}%)
                            </option>
                        @endforeach
                    </select>
                    <button id="btn-update-stage" type="submit" class="btn-primary w-full">Atualizar</button>
                </form>
            </div>

            <div id="deal-actions-card" class="card space-y-3">
                <a id="btn-edit-deal" href="{{ route('deals.edit', $deal) }}" class="btn-ghost w-full text-center">Editar</a>
                <a id="btn-view-kanban" href="{{ route('deals.kanban', $deal->pipeline_id) }}" class="btn-ghost w-full text-center">Ver Kanban</a>
                <form id="delete-form-deal" method="POST" action="{{ route('deals.destroy', $deal) }}"
                      x-data @submit.prevent="$dispatch('dialog', { 
                          title: 'Remover Oportunidade', 
                          message: 'Deseja realmente excluir esta oportunidade?',
                          type: 'danger',
                          onConfirm: () => $el.submit()
                      })">
                    @csrf @method('DELETE')
                    <button id="btn-delete-deal" type="submit" class="btn-danger w-full">Excluir</button>
                </form>
            </div>
        </div>
    </div>
</x-layouts.app>
