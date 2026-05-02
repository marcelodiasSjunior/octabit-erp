<x-layouts.app :title="'Kanban — ' . $pipeline->name" :header="'Kanban — ' . $pipeline->name">

    <div class="mb-4 flex items-center justify-between">
        <a id="btn-back-deals" href="{{ route('deals.index') }}" class="text-sm text-slate-400 hover:text-slate-200">← Lista de Oportunidades</a>
        <a id="btn-create-deal" href="{{ route('deals.create') }}" class="btn-primary">+ Nova Oportunidade</a>
    </div>

    {{-- Kanban board --}}
    <div id="kanban-board" class="flex gap-4 overflow-x-auto pb-4" x-data="kanban()">
        @foreach($pipeline->stages as $stage)
            <div
                id="stage-column-{{ $stage->id }}"
                class="flex-shrink-0 w-72 bg-bg-secondary rounded-xl border border-bg-border flex flex-col"
                x-on:dragover.prevent
                x-on:drop="onDrop($event, {{ $stage->id }})"
                data-stage="{{ $stage->id }}"
            >
                {{-- Stage header --}}
                <div class="px-4 py-3 border-b border-bg-border flex items-center justify-between">
                    <div>
                        <span class="text-sm font-semibold text-slate-200">{{ $stage->name }}</span>
                        <span class="ml-2 text-xs text-slate-500">{{ $stage->probability }}%</span>
                    </div>
                    <span class="text-xs text-slate-500 tabular-nums">
                        {{ $stage->deals->count() }}
                    </span>
                </div>

                {{-- Deal cards --}}
                <div class="flex-1 p-3 space-y-2 min-h-[120px]">
                    @foreach($stage->deals as $deal)
                        <div
                            id="deal-card-{{ $deal->id }}"
                            class="bg-bg-elevated border border-bg-border rounded-lg p-3 cursor-grab active:cursor-grabbing hover:border-octa-500/40 transition-colors"
                            draggable="true"
                            x-on:dragstart="onDragStart($event, {{ $deal->id }})"
                        >
                            <a id="link-deal-{{ $deal->id }}" href="{{ route('deals.show', $deal) }}" class="block">
                                <p class="text-sm font-medium text-slate-200 leading-snug">{{ $deal->title }}</p>
                                <p class="text-xs text-slate-500 mt-1">{{ $deal->client->display_name }}</p>
                                <p class="text-xs text-octa-400 font-semibold mt-2">R$ {{ number_format((float) $deal->value, 2, ',', '.') }}</p>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach
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
</x-layouts.app>
