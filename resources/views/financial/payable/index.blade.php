<x-layouts.app title="Contas a Pagar" header="Contas a Pagar">

    <div id="payables-toolbar" class="flex flex-col sm:flex-row sm:items-center gap-3 mb-6">
        <form method="GET" action="{{ route('payable.index') }}"
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
                <a id="btn-clear-filters" href="{{ route('payable.index') }}" class="btn-ghost btn-sm self-center">Limpar</a>
            @endif
        </form>

        <a id="btn-create-payable" href="{{ route('payable.create') }}" class="btn-primary whitespace-nowrap self-start sm:self-auto">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Nova Conta
        </a>
    </div>

    @if(session('success'))
        <div id="flash-success" class="mb-4 px-4 py-3 rounded-lg bg-green-500/10 border border-green-500/30 text-green-400 text-sm">
            {{ session('success') }}
        </div>
    @endif

    <div id="payables-table-container" class="table-wrapper">
        <table id="payables-table" class="table">
            <thead>
                <tr>
                    <th>Descrição</th>
                    <th>Categoria</th>
                    <th>Valor</th>
                    <th>Vencimento</th>
                    <th>Pagamento</th>
                    <th>Status</th>
                    <th class="text-right">Ações</th>
                </tr>
            </thead>
            <tbody>
                @forelse($payables as $payable)
                    <tr id="payable-row-{{ $payable->id }}" @class(['opacity-60' => $payable->status->value === 'canceled'])>
                        <td>
                            <p id="payable-desc-{{ $payable->id }}" class="font-medium text-slate-200">{{ $payable->description }}</p>
                            @if($payable->notes)
                                <p id="payable-notes-{{ $payable->id }}" class="text-xs text-slate-500 truncate max-w-xs">{{ $payable->notes }}</p>
                            @endif
                        </td>
                        <td id="payable-category-{{ $payable->id }}" class="text-slate-400 text-sm">{{ $payable->category ?? '—' }}</td>
                        <td id="payable-amount-{{ $payable->id }}" class="font-semibold text-slate-200">R$ {{ number_format($payable->amount, 2, ',', '.') }}</td>
                        <td id="payable-due-date-{{ $payable->id }}" class="text-sm @if($payable->status->value === 'overdue') text-red-400 @else text-slate-400 @endif">
                            {{ $payable->due_date->format('d/m/Y') }}
                        </td>
                        <td id="payable-payment-date-{{ $payable->id }}" class="text-sm text-slate-400">
                            {{ $payable->payment_date?->format('d/m/Y') ?? '—' }}
                        </td>
                        <td><x-status-badge :status="$payable->status"/></td>
                        <td>
                            <div class="flex items-center justify-end gap-2">
                                @if($payable->status->value === 'pending' || $payable->status->value === 'overdue')
                                    <form id="mark-paid-form-{{ $payable->id }}" method="POST" action="{{ route('payable.mark-paid', $payable->id) }}"
                                          x-data class="flex items-center gap-1">
                                        @csrf @method('PATCH')
                                        <input type="hidden" name="payment_date" value="{{ now()->toDateString() }}"/>
                                        <button id="btn-mark-paid-{{ $payable->id }}" type="submit" class="btn-ghost btn-sm text-green-400 hover:text-green-300"
                                                title="Marcar como pago">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                            </svg>
                                        </button>
                                    </form>
                                @endif

                                <form id="delete-form-payable-{{ $payable->id }}" method="POST" action="{{ route('payable.destroy', $payable->id) }}"
                                      x-data @submit.prevent="$dispatch('dialog', { 
                                          title: 'Remover Conta a Pagar', 
                                          message: 'Deseja realmente excluir esta conta a pagar?',
                                          type: 'danger',
                                          onConfirm: () => $el.submit()
                                      })">
                                    @csrf @method('DELETE')
                                    <button id="btn-delete-payable-{{ $payable->id }}" type="submit" class="btn-ghost btn-sm text-red-500 hover:text-red-400">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr id="no-payables-row">
                        <td colspan="7" class="text-center py-12 text-slate-500">
                            Nenhuma conta a pagar. <a id="link-create-first-payable" href="{{ route('payable.create') }}" class="text-octa-400 hover:underline">Adicione a primeira.</a>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($payables->hasPages())
        <div id="payables-pagination" class="mt-4">{{ $payables->links() }}</div>
    @endif

</x-layouts.app>
