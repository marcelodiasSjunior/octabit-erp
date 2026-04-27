<x-layouts.app title="Orçamentos" header="Orçamentos">

    {{-- Toolbar --}}
    <div id="quotes-toolbar" class="flex flex-col sm:flex-row sm:items-center gap-3 mb-6">
        <form method="GET" action="{{ route('quotes.index') }}"
              class="flex flex-1 flex-col sm:flex-row gap-3" id="filter-form">

            <input
                id="input-search"
                type="search"
                name="search"
                value="{{ $filters['search'] ?? '' }}"
                placeholder="Buscar por cliente..."
                class="input flex-1 max-w-sm"
            />

            <select id="select-status" name="status" class="select w-auto" onchange="document.getElementById('filter-form').submit()">
                <option value="">Todos os status</option>
                @foreach(\App\Enums\QuoteStatus::cases() as $status)
                    <option value="{{ $status->value }}"
                        {{ ($filters['status'] ?? '') === $status->value ? 'selected' : '' }}>
                        {{ $status->label() }}
                    </option>
                @endforeach
            </select>

            @if(!empty($filters['search']) || !empty($filters['status']))
                <a id="btn-clear-filters" href="{{ route('quotes.index') }}" class="btn-ghost btn-sm self-center">
                    Limpar
                </a>
            @endif
        </form>

        <a id="btn-create-quote" href="{{ route('quotes.create') }}" class="btn-primary whitespace-nowrap self-start sm:self-auto">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Novo Orçamento
        </a>
    </div>

    {{-- Flash --}}
    @if(session('success'))
        <div id="flash-success" class="mb-4 px-4 py-3 rounded-lg bg-green-500/10 border border-green-500/30 text-green-400 text-sm">
            {{ session('success') }}
        </div>
    @endif

    {{-- Table --}}
    <div id="quotes-table-wrapper" class="table-wrapper">
        <table id="quotes-table" class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Cliente</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Válido até</th>
                    <th class="text-right">Ações</th>
                </tr>
            </thead>
            <tbody>
                @forelse($quotes as $quote)
                    <tr id="quote-row-{{ $quote->id }}">
                        <td class="font-mono text-slate-400 text-xs">{{ $quote->id }}</td>
                        <td class="font-medium text-slate-200">{{ $quote->client->name ?? '—' }}</td>
                        <td class="font-semibold text-octa-300">R$ {{ number_format($quote->total, 2, ',', '.') }}</td>
                        <td><x-status-badge :status="$quote->status"/></td>
                        <td class="text-slate-400 text-sm">
                            @if($quote->valid_until)
                                <span @class(['text-red-400' => $quote->valid_until->isPast() && $quote->status->value !== 'approved'])>
                                    {{ $quote->valid_until->format('d/m/Y') }}
                                </span>
                            @else
                                —
                            @endif
                        </td>
                        <td>
                            <div class="flex items-center justify-end gap-2">
                                <a id="btn-view-quote-{{ $quote->id }}" href="{{ route('quotes.show', $quote) }}"
                                   class="btn-ghost btn-sm" title="Ver detalhes">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0zM2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                </a>

                                @if(in_array($quote->status->value, ['draft']))
                                    <a id="btn-edit-quote-{{ $quote->id }}" href="{{ route('quotes.edit', $quote) }}"
                                       class="btn-ghost btn-sm" title="Editar">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                    </a>
                                @endif

                                <form id="delete-form-quote-{{ $quote->id }}" method="POST" action="{{ route('quotes.destroy', $quote) }}"
                                      x-data
                                      @submit.prevent="if(confirm('Remover orçamento #{{ $quote->id }}?')) $el.submit()">
                                    @csrf
                                    @method('DELETE')
                                    <button id="btn-delete-quote-{{ $quote->id }}" type="submit" class="btn-ghost btn-sm text-red-500 hover:text-red-400" title="Remover">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr id="table-empty-row">
                        <td colspan="6" class="text-center py-12 text-slate-500">
                            <svg class="w-10 h-10 mx-auto mb-3 opacity-40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 00 2 2h10a2 2 0 00 2-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 0 0 2 2h2a2 2 0 00 2-2M9 5a2 2 0 1 1 4 0M9 12h6M9 16h4"/>
                            </svg>
                            Nenhum orçamento encontrado.
                            <a id="btn-create-first" href="{{ route('quotes.create') }}" class="text-octa-400 hover:text-octa-300 ml-1">Criar o primeiro?</a>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    @if($quotes->hasPages())
        <div class="mt-4">
            {{ $quotes->withQueryString()->links('pagination::tailwind') }}
        </div>
    @endif

</x-layouts.app>
