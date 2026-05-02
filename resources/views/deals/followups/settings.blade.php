<x-layouts.app title="Configurações de Follow-up" header="Configurações de Follow-up">
    <div id="settings-grid" class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div id="sla-creation-card" class="card">
            <h2 class="text-lg font-semibold text-slate-100 mb-4">Novo SLA</h2>
            <form id="form-add-sla" method="POST" action="{{ route('followups.settings.slas.store') }}" class="space-y-3">
                @csrf
                <div>
                    <label class="form-label">Pipeline</label>
                    <select id="select-sla-pipeline" name="pipeline_id" class="ajax-select" required>
                        @foreach($pipelines as $pipeline)
                            <option value="{{ $pipeline->id }}">{{ $pipeline->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="form-label">Nome</label>
                    <input id="input-sla-name" name="name" class="input" required>
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="form-label">SLA (horas)</label>
                        <input id="input-sla-hours" name="response_sla_hours" type="number" min="1" value="24" class="input" required>
                    </div>
                    <div>
                        <label class="form-label">Intervalo (dias)</label>
                        <input id="input-sla-interval" name="followup_interval_days" type="number" min="1" value="3" class="input" required>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="form-label">Escalação (dias)</label>
                        <input id="input-sla-escalation" name="escalation_threshold_days" type="number" min="1" value="2" class="input">
                    </div>
                    <div>
                        <label class="form-label">Prioridade</label>
                        <input id="input-sla-priority" name="priority" type="number" min="0" value="10" class="input" required>
                    </div>
                </div>
                <input type="hidden" name="warning_hours_before" value="4">
                <label class="inline-flex items-center gap-2 text-sm text-slate-300">
                    <input id="checkbox-sla-active" type="checkbox" name="active" value="1" checked>
                    Ativo
                </label>
                <button id="btn-save-sla" type="submit" class="btn-primary">Salvar SLA</button>
            </form>
        </div>

        <div id="rule-creation-card" class="card">
            <h2 class="text-lg font-semibold text-slate-100 mb-4">Nova Regra</h2>
            <form id="form-add-rule" method="POST" action="{{ route('followups.settings.rules.store') }}" class="space-y-3">
                @csrf
                <div>
                    <label class="form-label">Pipeline</label>
                    <select id="select-rule-pipeline" name="pipeline_id" class="ajax-select" required>
                        @foreach($pipelines as $pipeline)
                            <option value="{{ $pipeline->id }}">{{ $pipeline->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="form-label">Regra</label>
                    <input id="input-rule-name" name="name" class="input" required>
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="form-label">Trigger</label>
                        <input id="input-rule-trigger" name="trigger_type" value="days_without_activity" class="input" required>
                    </div>
                    <div>
                        <label class="form-label">Valor</label>
                        <input id="input-rule-value" name="trigger_value" value="3" class="input" required>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="form-label">Ação</label>
                        <input id="input-rule-action" name="action_type" value="create_activity" class="input" required>
                    </div>
                    <div>
                        <label class="form-label">Tipo atividade</label>
                        <input id="input-rule-activity-type" name="activity_type" value="task" class="input">
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="form-label">Ordem</label>
                        <input id="input-rule-order" type="number" min="0" name="order" value="1" class="input" required>
                    </div>
                    <div>
                        <label class="form-label">Cooldown (h)</label>
                        <input id="input-rule-cooldown" type="number" min="0" name="cooldown_hours" value="24" class="input" required>
                    </div>
                </div>
                <label class="inline-flex items-center gap-2 text-sm text-slate-300">
                    <input id="checkbox-rule-no-activity" type="checkbox" name="only_if_no_recent_activity" value="1" checked>
                    Apenas sem atividade recente
                </label>
                <label class="inline-flex items-center gap-2 text-sm text-slate-300 ml-4">
                    <input id="checkbox-rule-active" type="checkbox" name="active" value="1" checked>
                    Ativa
                </label>
                <button id="btn-save-rule" type="submit" class="btn-primary">Salvar Regra</button>
            </form>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mt-6">
        <div id="slas-list-card" class="card">
            <h3 class="text-sm font-semibold text-slate-200 mb-3">SLAs Cadastrados</h3>
            <div id="slas-list" class="space-y-2 text-sm text-slate-300">
                @forelse($slas as $sla)
                    <div id="sla-item-{{ $sla->id }}" class="border border-bg-border rounded p-2">{{ $sla->name }} - {{ $sla->pipeline?->name }}</div>
                @empty
                    <div id="no-slas-msg" class="text-slate-500">Nenhum SLA cadastrado.</div>
                @endforelse
            </div>
        </div>
        <div id="rules-list-card" class="card">
            <h3 class="text-sm font-semibold text-slate-200 mb-3">Regras Cadastradas</h3>
            <div id="rules-list" class="space-y-2 text-sm text-slate-300">
                @forelse($rules as $rule)
                    <div id="rule-item-{{ $rule->id }}" class="border border-bg-border rounded p-2">{{ $rule->name }} - {{ $rule->pipeline?->name }}</div>
                @empty
                    <div id="no-rules-msg" class="text-slate-500">Nenhuma regra cadastrada.</div>
                @endforelse
            </div>
        </div>
    </div>
</x-layouts.app>
