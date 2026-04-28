<x-layouts.app title="Dashboard" header="Dashboard">

    <div x-data="{ 
        customizing: false,
        layout: {{ json_encode($layout) }},
        saveLayout() {
            fetch('{{ route('dashboard.update-layout') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ layout: this.layout })
            }).then(() => window.location.reload());
        }
    }">
        {{-- Toolbar de Personalização --}}
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-lg font-bold text-slate-100">Visão Geral</h2>
            <div class="flex gap-2">
                <button @click="customizing = !customizing" 
                        class="btn-secondary btn-sm"
                        :class="customizing ? 'bg-octa-500/20 border-octa-500/50 text-octa-300' : ''">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"/>
                    </svg>
                    <span x-text="customizing ? 'Sair da Edição' : 'Personalizar'"></span>
                </button>
                <button x-show="customizing" @click="saveLayout()" class="btn-primary btn-sm">Salvar Ordem</button>
            </div>
        </div>

        {{-- Grid Dinâmico de Widgets --}}
        <div class="space-y-8">
            @foreach($layout as $widget)
                @if($widget['visible'])
                    
                    {{-- Widget: Cards de Resumo --}}
                    @if($widget['id'] === 'stat-cards')
                        <div id="stat-cards-grid" class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4" :class="customizing ? 'ring-2 ring-dashed ring-octa-500/30 p-2 rounded-xl relative' : ''">
                            <x-stat-card id="stat-active-clients" label="Clientes Ativos" :value="number_format($activeClients)" color="emerald" sub="Total cadastrado como ativo">
                                <x-slot:icon><x-nav-item-icon icon="users" class="w-6 h-6"/></x-slot:icon>
                            </x-stat-card>
                            <x-stat-card id="stat-leads" label="Leads" :value="number_format($totalLeads)" color="blue" sub="Aguardando conversão">
                                <x-slot:icon><x-nav-item-icon icon="target" class="w-6 h-6"/></x-slot:icon>
                            </x-stat-card>
                            <x-stat-card id="stat-received-month" label="Recebido (mês)" :value="'R$ ' . number_format($totalPaidThisMonth, 2, ',', '.')" color="octa" sub="{{ now()->format('M/Y') }}">
                                <x-slot:icon><x-nav-item-icon icon="trending-up" class="w-6 h-6"/></x-slot:icon>
                            </x-stat-card>
                            <x-stat-card id="stat-to-receive-month" label="A Receber (mês)" :value="'R$ ' . number_format($totalDueThisMonth, 2, ',', '.')" color="yellow" sub="Pendente + Vencido">
                                <x-slot:icon><x-nav-item-icon icon="trending-down" class="w-6 h-6"/></x-slot:icon>
                            </x-stat-card>
                        </div>
                    @endif

                    {{-- Widget: Cards de CRM --}}
                    @if($widget['id'] === 'crm-stat-cards')
                        <div id="crm-stats-grid" class="grid grid-cols-1 sm:grid-cols-3 gap-4" :class="customizing ? 'ring-2 ring-dashed ring-octa-500/30 p-2 rounded-xl relative' : ''">
                            <x-stat-card id="stat-open-deals" label="Oportunidades Abertas" :value="number_format($openDeals)" color="octa" sub="Pipeline ativo">
                                <x-slot:icon><x-nav-item-icon icon="clipboard" class="w-6 h-6"/></x-slot:icon>
                            </x-stat-card>
                            <x-stat-card id="stat-won-deals" label="Fechamentos (mês)" :value="number_format($wonDealsThisMonth)" color="emerald" sub="{{ now()->format('M/Y') }}">
                                <x-slot:icon><x-nav-item-icon icon="target" class="w-6 h-6"/></x-slot:icon>
                            </x-stat-card>
                            <x-stat-card id="stat-weighted-pipeline" label="Pipeline Ponderado" :value="'R$ ' . number_format($weightedPipeline, 2, ',', '.')" color="blue" sub="Valor × probabilidade">
                                <x-slot:icon><x-nav-item-icon icon="trending-up" class="w-6 h-6"/></x-slot:icon>
                            </x-stat-card>
                        </div>
                    @endif

                    {{-- Widget: Gráficos --}}
                    @if($widget['id'] === 'revenue-chart')
                        <div id="dashboard-charts" class="grid grid-cols-1 lg:grid-cols-3 gap-6" :class="customizing ? 'ring-2 ring-dashed ring-octa-500/30 p-2 rounded-xl relative' : ''">
                            <div class="card p-6 lg:col-span-2">
                                <div class="flex items-center justify-between mb-6">
                                    <div>
                                        <h2 class="text-sm font-semibold text-slate-200">Desempenho Financeiro</h2>
                                        <p class="text-xs text-slate-500 mt-1">Receita realizada nos últimos 6 meses</p>
                                    </div>
                                    <div class="flex items-center gap-2 text-xs text-slate-400">
                                        <span class="w-2 h-2 rounded-full bg-octa-500"></span> Receita (R$)
                                    </div>
                                </div>
                                <x-chart id="revenue-chart-el" type="area" :labels="$charts['revenue']['labels']" :series="$charts['revenue']['series']" :height="300" />
                            </div>
                            <div class="card p-6 lg:col-span-1">
                                <div class="mb-6">
                                    <h2 class="text-sm font-semibold text-slate-200">Distribuição de Tags</h2>
                                    <p class="text-xs text-slate-500 mt-1">Categorias na base</p>
                                </div>
                                <div class="flex flex-col justify-center h-[300px]">
                                    <x-chart id="tags-chart-el" type="donut" :labels="$charts['tags_distribution']['labels']" :series="$charts['tags_distribution']['series']" :colors="$charts['tags_distribution']['colors']" :height="300" />
                                </div>
                            </div>
                        </div>
                    @endif

                    {{-- Widget: Status e Ações --}}
                    @if($widget['id'] === 'status-breakdown' || $widget['id'] === 'quick-actions')
                        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6" :class="customizing ? 'ring-2 ring-dashed ring-octa-500/30 p-2 rounded-xl relative' : ''">
                            {{-- Breakdowns --}}
                            <div id="status-breakdown-card" class="lg:col-span-1">
                                <div class="card">
                                    <h2 class="text-sm font-semibold text-slate-200 mb-4">Cobranças por Status</h2>
                                    <div class="space-y-3">
                                        @foreach([['s' => \App\Enums\PaymentStatus::Pending, 'k' => 'pending'], ['s' => \App\Enums\PaymentStatus::Paid, 'k' => 'paid'], ['s' => \App\Enums\PaymentStatus::Overdue, 'k' => 'overdue']] as $item)
                                            @php
                                                $count = $receivableByStatus[$item['k']] ?? 0;
                                                $total = array_sum($receivableByStatus);
                                                $pct = $total > 0 ? round(($count / $total) * 100) : 0;
                                            @endphp
                                            <div>
                                                <div class="flex justify-between items-center mb-1">
                                                    <x-status-badge :status="$item['s']"/>
                                                    <span class="text-sm font-semibold text-slate-300">{{ $count }}</span>
                                                </div>
                                                <div class="w-full h-1.5 bg-bg-border rounded-full overflow-hidden">
                                                    <div class="h-full rounded-full transition-all duration-500 {{ $item['k'] === 'paid' ? 'bg-emerald-500' : ($item['k'] === 'overdue' ? 'bg-red-500' : 'bg-yellow-500') }}" style="width: {{ $pct }}%"></div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            {{-- Quick actions --}}
                            <div id="quick-actions-card" class="lg:col-span-2">
                                <div class="card">
                                    <h2 class="text-sm font-semibold text-slate-200 mb-4">Ações Rápidas</h2>
                                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                                        <a href="{{ route('clients.create') }}" class="flex flex-col items-center gap-2 p-4 rounded-lg border border-bg-border hover:border-octa-500/40 hover:bg-octa-500/5 text-slate-400 hover:text-octa-400 transition-all text-center">
                                            <x-nav-item-icon icon="users" class="w-6 h-6"/> <span class="text-xs font-medium">Novo Cliente</span>
                                        </a>
                                        <a href="{{ route('receivable.create') }}" class="flex flex-col items-center gap-2 p-4 rounded-lg border border-bg-border hover:border-emerald-500/40 hover:bg-emerald-500/5 text-slate-400 hover:text-emerald-400 transition-all text-center">
                                            <x-nav-item-icon icon="clipboard" class="w-6 h-6"/> <span class="text-xs font-medium">Nova Cobrança</span>
                                        </a>
                                        <a href="{{ route('receivable.index', ['status' => 'overdue']) }}" class="flex flex-col items-center gap-2 p-4 rounded-lg border border-bg-border hover:border-red-500/40 hover:bg-red-500/5 text-slate-400 hover:text-red-400 transition-all text-center">
                                            <x-nav-item-icon icon="target" class="w-6 h-6"/> <span class="text-xs font-medium">Vencidos</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                @endif
            @endforeach
        </div>
    </div>
</x-layouts.app>
