<x-layouts.app title="Relatório Financeiro" header="Relatórios / Financeiro">

    {{-- Filtros --}}
    <div class="card mb-6">
        <form method="GET" action="{{ route('reports.financial') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
            <div>
                <label class="label">Data Início</label>
                <input type="date" name="start_date" value="{{ $filters['start_date'] }}" class="input">
            </div>
            <div>
                <label class="label">Data Fim</label>
                <input type="date" name="end_date" value="{{ $filters['end_date'] }}" class="input">
            </div>
            <div>
                <label class="label">Status</label>
                <select name="status" class="ajax-select">
                    <option value="">Todos os Status</option>
                    <option value="paid" {{ $filters['status'] == 'paid' ? 'selected' : '' }}>Pagos / Recebidos</option>
                    <option value="pending" {{ $filters['status'] == 'pending' ? 'selected' : '' }}>Pendentes</option>
                    <option value="overdue" {{ $filters['status'] == 'overdue' ? 'selected' : '' }}>Atrasados</option>
                </select>
            </div>
            <div class="flex gap-2">
                <button type="submit" class="btn-primary flex-1">Filtrar</button>
                <a href="{{ route('reports.export', ['type' => 'financial', 'format' => 'csv'] + request()->all()) }}" class="btn-secondary" title="Exportar CSV">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                </a>
                <a href="{{ route('reports.export', ['type' => 'financial', 'format' => 'pdf'] + request()->all()) }}" class="btn-secondary" title="Exportar PDF">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                    </svg>
                </a>
                <a href="{{ route('reports.financial') }}" class="btn-secondary" title="Limpar">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M6 18L18 6M6 6l12 12"/></svg>
                </a>
            </div>
        </form>
    </div>

    {{-- Resumo --}}
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <x-stat-card 
            label="Total Recebido" 
            value="R$ {{ number_format($summary['total_received'], 2, ',', '.') }}" 
            color="emerald" 
            icon='<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 4v16m8-8H4"/></svg>'
        />
        <x-stat-card 
            label="A Receber" 
            value="R$ {{ number_format($summary['total_receivable'], 2, ',', '.') }}" 
            color="blue" 
            icon='<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>'
        />
        <x-stat-card 
            label="Total Pago" 
            value="R$ {{ number_format($summary['total_paid'], 2, ',', '.') }}" 
            color="red" 
            icon='<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M20 12H4"/></svg>'
        />
        <x-stat-card 
            label="Saldo Realizado" 
            value="R$ {{ number_format($summary['balance'], 2, ',', '.') }}" 
            color="{{ $summary['balance'] >= 0 ? 'emerald' : 'red' }}" 
            icon='<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>'
        />
    </div>

    {{-- Gráfico --}}
    <div class="card mb-6">
        <h3 class="text-base font-semibold text-slate-200 mb-4">Fluxo de Caixa Mensal (Pagos x Recebidos)</h3>
        <x-chart 
            type="bar" 
            :labels="array_column($chartData, 'label')"
            :series="[
                ['name' => 'Recebido', 'data' => array_column($chartData, 'received')],
                ['name' => 'Pago', 'data' => array_column($chartData, 'paid')]
            ]"
            :colors="['#10b981', '#ef4444']"
        />
    </div>

    {{-- Tabelas Detalhadas --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        {{-- Recebíveis --}}
        <div class="card">
            <h3 class="text-base font-semibold text-slate-200 mb-4">Entradas (Contas a Receber)</h3>
            <div class="table-wrapper">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Data</th>
                            <th>Cliente</th>
                            <th>Valor</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($receivables as $item)
                            <tr>
                                <td class="whitespace-nowrap">{{ \Carbon\Carbon::parse($item->due_date)->format('d/m/Y') }}</td>
                                <td class="truncate max-w-[150px]">{{ $item->client?->display_name ?? '—' }}</td>
                                <td class="font-medium text-emerald-400">R$ {{ number_format($item->amount, 2, ',', '.') }}</td>
                                <td><x-status-badge :status="$item->status"/></td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="text-center py-8 text-slate-500 italic">Nenhuma entrada encontrada</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Pagáveis --}}
        <div class="card">
            <h3 class="text-base font-semibold text-slate-200 mb-4">Saídas (Contas a Pagar)</h3>
            <div class="table-wrapper">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Data</th>
                            <th>Descrição</th>
                            <th>Valor</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($payables as $item)
                            <tr>
                                <td class="whitespace-nowrap">{{ \Carbon\Carbon::parse($item->due_date)->format('d/m/Y') }}</td>
                                <td class="truncate max-w-[150px]">{{ $item->description }}</td>
                                <td class="font-medium text-red-400">R$ {{ number_format($item->amount, 2, ',', '.') }}</td>
                                <td><x-status-badge :status="$item->status"/></td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="text-center py-8 text-slate-500 italic">Nenhuma saída encontrada</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</x-layouts.app>
