<x-layouts.app title="Relatório de Orçamentos" header="Relatórios / Orçamentos">

    {{-- Filtros --}}
    <div class="card mb-6">
        <form method="GET" action="{{ route('reports.quotes') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
            <div>
                <label class="label">Data Início</label>
                <input type="date" name="start_date" value="{{ $filters['start_date'] }}" class="input">
            </div>
            <div>
                <label class="label">Data Fim</label>
                <input type="date" name="end_date" value="{{ $filters['end_date'] }}" class="input">
            </div>
            <div>
                <label class="label">Cliente</label>
                <select name="client_id" class="ajax-select" data-search-url="{{ route('search.clients') }}">
                    <option value="">Todos os Clientes</option>
                    @if($filters['client_id'])
                        @php $selectedClient = \App\Models\Client::find($filters['client_id']); @endphp
                        @if($selectedClient)
                            <option value="{{ $selectedClient->id }}" selected>{{ $selectedClient->display_name }}</option>
                        @endif
                    @endif
                </select>
            </div>
            <div class="flex gap-2">
                <button type="submit" class="btn-primary flex-1">Filtrar</button>
                <a href="{{ route('reports.export', ['type' => 'quotes', 'format' => 'csv'] + request()->all()) }}" class="btn-secondary" title="Exportar CSV">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                </a>
                <a href="{{ route('reports.export', ['type' => 'quotes', 'format' => 'pdf'] + request()->all()) }}" class="btn-secondary" title="Exportar PDF">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                    </svg>
                </a>
                <a href="{{ route('reports.quotes') }}" class="btn-secondary" title="Limpar">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M6 18L18 6M6 6l12 12"/></svg>
                </a>
            </div>
        </form>
    </div>

    {{-- Resumo --}}
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <x-stat-card 
            label="Total Orçamentos" 
            value="{{ $summary['total_count'] }}" 
            color="octa" 
            icon='<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>'
        />
        <x-stat-card 
            label="Taxa de Conversão" 
            value="{{ number_format($summary['conversion_rate'], 1, ',', '.') }}%" 
            color="emerald" 
            icon='<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>'
            sub="{{ $summary['approved_count'] }} orçamentos aprovados"
        />
        <x-stat-card 
            label="Valor Aprovado" 
            value="R$ {{ number_format($summary['total_value_approved'], 2, ',', '.') }}" 
            color="emerald" 
            icon='<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>'
        />
        <x-stat-card 
            label="Valor Rejeitado" 
            value="R$ {{ number_format($summary['total_value_rejected'], 2, ',', '.') }}" 
            color="red" 
            icon='<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>'
        />
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
        {{-- Gráfico de Status --}}
        <div class="card lg:col-span-1">
            <h3 class="text-base font-semibold text-slate-200 mb-4">Distribuição por Status</h3>
            <x-chart 
                type="donut" 
                :labels="['Aprovados', 'Rejeitados', 'Pendentes']"
                :series="[(int)$summary['approved_count'], (int)$summary['rejected_count'], (int)$summary['pending_count']]"
                :colors="['#10b981', '#ef4444', '#f59e0b']"
            />
        </div>

        {{-- Tabela Detalhada --}}
        <div class="card lg:col-span-2">
            <h3 class="text-base font-semibold text-slate-200 mb-4">Listagem Detalhada</h3>
            <div class="table-wrapper">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Data</th>
                            <th>Cliente</th>
                            <th>Total</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($quotes as $quote)
                            <tr>
                                <td>{{ $quote->created_at->format('d/m/Y') }}</td>
                                <td>{{ $quote->client->display_name }}</td>
                                <td class="font-medium">R$ {{ number_format($quote->total, 2, ',', '.') }}</td>
                                <td>
                                    <span class="px-2 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider
                                        {{ $quote->status === \App\Enums\QuoteStatus::Approved ? 'bg-emerald-500/20 text-emerald-400' : '' }}
                                        {{ $quote->status === \App\Enums\QuoteStatus::Rejected ? 'bg-red-500/20 text-red-400' : '' }}
                                        {{ $quote->status === \App\Enums\QuoteStatus::Sent ? 'bg-blue-500/20 text-blue-400' : '' }}
                                        {{ $quote->status === \App\Enums\QuoteStatus::Draft ? 'bg-slate-500/20 text-slate-400' : '' }}
                                    ">
                                        {{ $quote->status->label() }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="text-center py-8 text-slate-500 italic">Nenhum orçamento encontrado</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</x-layouts.app>
