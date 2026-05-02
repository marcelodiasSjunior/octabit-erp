<x-layouts.app title="Contas a Receber" header="Contas a Receber">

    {{-- Toolbar --}}
    <div id="receivables-toolbar" class="flex flex-col sm:flex-row sm:items-center gap-3 mb-6">
        <form method="GET" action="{{ route('receivable.index') }}"
              class="flex flex-1 flex-wrap gap-3" id="filter-form">

            <select id="select-status" name="status" class="ajax-select w-auto" onchange="document.getElementById('filter-form').submit()">
                <option value="">Todos os status</option>
                @foreach(\App\Enums\PaymentStatus::cases() as $status)
                    <option value="{{ $status->value }}"
                        {{ ($filters['status'] ?? '') === $status->value ? 'selected' : '' }}>
                        {{ $status->label() }}
                    </option>
                @endforeach
            </select>

            @if(!empty($filters['status']))
                <a id="btn-clear-filters" href="{{ route('receivable.index') }}" class="btn-ghost btn-sm self-center">Limpar</a>
            @endif
        </form>

        <a id="btn-create-receivable" href="{{ route('receivable.create') }}" class="btn-primary whitespace-nowrap self-start sm:self-auto">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Nova Cobrança
        </a>
    </div>

    {{-- Table --}}
    <div id="receivables-table-wrapper" class="table-wrapper">
        <table id="receivables-table" class="table">
            <thead>
                <tr>
                    <th>Descrição</th>
                    <th>Cliente</th>
                    <th>Valor</th>
                    <th>Vencimento</th>
                    <th>Pagamento</th>
                    <th>Status</th>
                    <th class="text-right">Ações</th>
                </tr>
            </thead>
            <tbody>
                @forelse($receivables as $ar)
                    <tr id="receivable-row-{{ $ar->id }}" @class(['opacity-60' => $ar->status->value === 'canceled'])>
                        <td>
                            <p class="font-medium text-slate-200">{{ $ar->description }}</p>
                            @if($ar->notes)
                                <p class="text-xs text-slate-500 truncate max-w-xs">{{ $ar->notes }}</p>
                            @endif
                        </td>
                        <td>
                            @if($ar->client)
                            <a id="link-client-{{ $ar->client->id }}-receivable-{{ $ar->id }}" href="{{ route('clients.show', $ar->client) }}"  
                               class="text-sm text-octa-400 hover:text-octa-300 transition-colors">
                                {{ $ar->client->name }}
                            </a>
                            @else
                                <span class="text-sm text-slate-500">—</span>
                            @endif
                        </td>
                        <td class="font-semibold text-slate-200">
                            R$ {{ number_format($ar->amount, 2, ',', '.') }}
                        </td>
                        <td @class(['text-red-400' => $ar->status->isOverdue()])>
                            {{ $ar->due_date->format('d/m/Y') }}
                        </td>
                        <td class="text-slate-400">
                            {{ $ar->payment_date ? $ar->payment_date->format('d/m/Y') : '—' }}
                        </td>
                        <td><x-status-badge :status="$ar->status"/></td>
                        <td>
                            <div class="flex items-center justify-end gap-2">
                                {{-- Quick mark as paid --}}
                                @if(!$ar->status->isPaid() && $ar->status->value !== 'canceled')
                                    <form id="mark-paid-form-{{ $ar->id }}" method="POST" action="{{ route('receivable.mark-paid', $ar->id) }}"
                                          x-data>
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="payment_date" value="{{ now()->toDateString() }}">
                                        <button id="btn-mark-paid-{{ $ar->id }}" type="submit"
                                                class="btn-ghost btn-sm text-emerald-400 hover:text-emerald-300"
                                                title="Marcar como pago hoje">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                            </svg>
                                        </button>
                                    </form>
                                @endif

                                <form id="cancel-form-receivable-{{ $ar->id }}" method="POST" action="{{ route('receivable.destroy', $ar) }}"
                                          x-data @submit.prevent="$dispatch('dialog', { 
                                              title: 'Cancelar Cobrança', 
                                              message: 'Deseja realmente cancelar esta cobrança?',
                                              type: 'danger',
                                              confirmText: 'Sim, cancelar',
                                              onConfirm: () => $el.submit()
                                          })">
                                    @csrf
                                    @method('DELETE')
                                    <button id="btn-cancel-receivable-{{ $ar->id }}" type="submit" class="btn-ghost btn-sm text-red-500 hover:text-red-400" title="Cancelar">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr id="table-empty-row">
                        <td colspan="7" class="text-center py-12 text-slate-500">
                            Nenhuma cobrança encontrada.
                            <a id="btn-create-first" href="{{ route('receivable.create') }}" class="text-octa-400 hover:text-octa-300 ml-1">
                                Criar a primeira?
                            </a>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($receivables->hasPages())
        <div class="mt-4">{{ $receivables->withQueryString()->links('pagination::tailwind') }}</div>
    @endif

</x-layouts.app>
