<x-layouts.app title="Dashboard de Follow-up" header="Dashboard de Follow-up">
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
        <x-stat-card label="Violações abertas" :value="number_format($totalUnresolved)" color="yellow" sub="pendentes" />
        <x-stat-card label="Críticas" :value="number_format($totalCritical)" color="red" sub="severity=critical" />
        <x-stat-card label="Severas" :value="number_format($totalSevere)" color="octa" sub="severity=severe" />
    </div>

    <div id="followup-dashboard-card" class="card mb-6">
        <form id="form-filter-followups" class="grid grid-cols-1 md:grid-cols-3 gap-3" method="GET" action="{{ route('followups.dashboard.index') }}">
            <div>
                <label class="form-label">Pipeline</label>
                <select id="select-pipeline-filter" name="pipeline_id" class="ajax-select">
                    <option value="">Todos</option>
                    @foreach($pipelines as $pipeline)
                        <option value="{{ $pipeline->id }}" @selected((int) $pipelineFilter === (int) $pipeline->id)>{{ $pipeline->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="form-label">Severidade</label>
                <select id="select-severity-filter" name="severity" class="ajax-select">
                    <option value="">Todas</option>
                    @foreach(['warning', 'critical', 'severe'] as $sev)
                        <option value="{{ $sev }}" @selected($severityFilter === $sev)>{{ $sev }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex items-end">
                <button id="btn-filter-followups" type="submit" class="btn-primary">Filtrar</button>
            </div>
        </form>
    </div>

    <div id="violations-container" class="card">
        <h2 class="text-sm font-semibold text-slate-200 mb-4">Violações</h2>
        <div id="violations-list" class="space-y-2">
            @forelse($violations as $violation)
                <div id="violation-card-{{ $violation->id }}" class="border border-bg-border rounded p-3 text-sm text-slate-300">
                    <div class="font-semibold">Deal #{{ $violation->deal_id }} - {{ $violation->severity }}</div>
                    <div>{{ $violation->deal?->pipeline?->name }} / {{ $violation->deal?->stage?->name }}</div>
                </div>
            @empty
                <div id="no-violations-msg" class="text-slate-500">Nenhuma violação encontrada.</div>
            @endforelse
        </div>
        <div id="violations-pagination" class="mt-4">{{ $violations->links() }}</div>
    </div>
</x-layouts.app>
