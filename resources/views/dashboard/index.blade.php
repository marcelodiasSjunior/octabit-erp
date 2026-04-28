<x-layouts.app title="Dashboard" header="Dashboard">

    {{-- Stat cards grid --}}
    <div id="stat-cards-grid" class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4 mb-8">

        <x-stat-card
            id="stat-active-clients"
            label="Clientes Ativos"
            :value="number_format($activeClients)"
            color="emerald"
            sub="Total cadastrado como ativo"
        >
            <x-slot:icon>
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
            </x-slot:icon>
        </x-stat-card>

        <x-stat-card
            id="stat-leads"
            label="Leads"
            :value="number_format($totalLeads)"
            color="blue"
            sub="Aguardando conversão"
        >
            <x-slot:icon>
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
            </x-slot:icon>
        </x-stat-card>

        <x-stat-card
            id="stat-received-month"
            label="Recebido (mês)"
            :value="'R$ ' . number_format($totalPaidThisMonth, 2, ',', '.')"
            color="octa"
            sub="{{ now()->format('M/Y') }}"
        >
            <x-slot:icon>
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </x-slot:icon>
        </x-stat-card>

        <x-stat-card
            id="stat-to-receive-month"
            label="A Receber (mês)"
            :value="'R$ ' . number_format($totalDueThisMonth, 2, ',', '.')"
            color="yellow"
            sub="Pendente + Vencido"
        >
            <x-slot:icon>
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                </svg>
            </x-slot:icon>
        </x-stat-card>
    </div>

    {{-- CRM Stat cards --}}
    <div id="crm-stats-grid" class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-8">
        <x-stat-card
            id="stat-open-deals"
            label="Oportunidades Abertas"
            :value="number_format($openDeals)"
            color="octa"
            sub="Pipeline ativo"
        >
            <x-slot:icon>
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                </svg>
            </x-slot:icon>
        </x-stat-card>

        <x-stat-card
            id="stat-won-deals"
            label="Fechamentos (mês)"
            :value="number_format($wonDealsThisMonth)"
            color="emerald"
            sub="{{ now()->format('M/Y') }}"
        >
            <x-slot:icon>
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                </svg>
            </x-slot:icon>
        </x-stat-card>

        <x-stat-card
            id="stat-weighted-pipeline"
            label="Pipeline Ponderado"
            :value="'R$ ' . number_format($weightedPipeline, 2, ',', '.')"
            color="blue"
            sub="Valor × probabilidade"
        >
            <x-slot:icon>
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                </svg>
            </x-slot:icon>
        </x-stat-card>
    </div>

    {{-- Charts Section --}}
    <div id="dashboard-charts" class="grid grid-cols-1 gap-6 mb-8">
        <div class="card p-6">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h2 class="text-sm font-semibold text-slate-200">Desempenho Financeiro</h2>
                    <p class="text-xs text-slate-500 mt-1">Receita realizada nos últimos 6 meses</p>
                </div>
                <div class="flex items-center gap-2">
                    <span class="flex items-center gap-1.5 text-xs text-slate-400">
                        <span class="w-2 h-2 rounded-full bg-octa-500"></span>
                        Receita (R$)
                    </span>
                </div>
            </div>
            <x-chart 
                id="revenue-chart"
                type="area" 
                :labels="$charts['revenue']['labels']" 
                :series="$charts['revenue']['series']"
                :height="320"
            />
        </div>
    </div>

    {{-- Payment status breakdown --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- Status breakdown chart / summary --}}
        <div id="status-breakdown-card" class="lg:col-span-1">
            <div class="card">
                <h2 class="text-sm font-semibold text-slate-200 mb-4">Cobranças por Status</h2>
                <div class="space-y-3">
                    @php
                        $statusData = [
                            ['status' => \App\Enums\PaymentStatus::Pending,  'key' => 'pending'],
                            ['status' => \App\Enums\PaymentStatus::Paid,     'key' => 'paid'],
                            ['status' => \App\Enums\PaymentStatus::Overdue,  'key' => 'overdue'],
                        ];
                        $total = array_sum($receivableByStatus);
                    @endphp

                    @foreach($statusData as $item)
                        @php
                            $count = $receivableByStatus[$item['key']] ?? 0;
                            $pct   = $total > 0 ? round(($count / $total) * 100) : 0;
                        @endphp
                        <div id="status-row-{{ $item['key'] }}">
                            <div class="flex justify-between items-center mb-1">
                                <x-status-badge :status="$item['status']"/>
                                <span class="text-sm font-semibold text-slate-300">{{ $count }}</span>
                            </div>
                            <div class="w-full h-1.5 bg-bg-border rounded-full overflow-hidden">
                                <div class="h-full rounded-full transition-all duration-500
                                    @if($item['key'] === 'paid') bg-emerald-500
                                    @elseif($item['key'] === 'overdue') bg-red-500
                                    @else bg-yellow-500 @endif"
                                    style="width: {{ $pct }}%">
                                </div>
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
                    <a id="btn-quick-new-client" href="{{ route('clients.create') }}"
                       class="flex flex-col items-center gap-2 p-4 rounded-lg border border-bg-border
                              hover:border-octa-500/40 hover:bg-octa-500/5 text-slate-400 hover:text-octa-400
                              transition-all duration-200 text-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                        </svg>
                        <span class="text-xs font-medium">Novo Cliente</span>
                    </a>

                    <a id="btn-quick-new-receivable" href="{{ route('receivable.create') }}"
                       class="flex flex-col items-center gap-2 p-4 rounded-lg border border-bg-border
                              hover:border-emerald-500/40 hover:bg-emerald-500/5 text-slate-400 hover:text-emerald-400
                              transition-all duration-200 text-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 14l6-6m-5.5.5h.01m4.99 5h.01M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16l3.5-2 3.5 2 3.5-2 3.5 2z"/>
                        </svg>
                        <span class="text-xs font-medium">Nova Cobrança</span>
                    </a>

                    <a id="btn-quick-view-overdue" href="{{ route('receivable.index', ['status' => 'overdue']) }}"
                       class="flex flex-col items-center gap-2 p-4 rounded-lg border border-bg-border
                              hover:border-red-500/40 hover:bg-red-500/5 text-slate-400 hover:text-red-400
                              transition-all duration-200 text-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                        <span class="text-xs font-medium">Vencidos</span>
                    </a>
                </div>
            </div>
        </div>
    </div>

</x-layouts.app>
