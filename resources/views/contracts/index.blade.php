<x-layouts.app title="Contratos" header="Contratos">

    <div id="contracts-toolbar" class="flex flex-col sm:flex-row sm:items-center gap-3 mb-6">
        <form method="GET" action="{{ route('contracts.index') }}"
              class="flex flex-1 flex-wrap gap-3" id="filter-form">
            <input id="input-search-contracts" type="search" name="search" value="{{ $filters['search'] ?? '' }}"
                   placeholder="Buscar por cliente..." class="input flex-1 max-w-xs"/>

            <select id="select-status" name="status" class="ajax-select w-auto" onchange="document.getElementById('filter-form').submit()">
                <option value="">Todos os status</option>
                @foreach(\App\Enums\ContractStatus::cases() as $status)
                    <option value="{{ $status->value }}"
                        {{ ($filters['status'] ?? '') === $status->value ? 'selected' : '' }}>
                        {{ $status->label() }}
                    </option>
                @endforeach
            </select>

            @if(!empty($filters['search']) || !empty($filters['status']))
                <a id="btn-clear-filters" href="{{ route('contracts.index') }}" class="btn-ghost btn-sm self-center">Limpar</a>
            @endif
        </form>

        <a id="btn-create-contract" href="{{ route('contracts.create') }}" class="btn-primary whitespace-nowrap self-start sm:self-auto">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Novo Contrato
        </a>
    </div>

    <div id="contracts-table-container" class="table-wrapper">
        <table id="contracts-table" class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Cliente</th>
                    <th>Valor</th>
                    <th>Vigência</th>
                    <th>Status</th>
                    <th class="text-right">Ações</th>
                </tr>
            </thead>
            <tbody>
                @forelse($contracts as $contract)
                    <tr id="contract-row-{{ $contract->id }}">
                        <td class="font-mono text-slate-400 text-xs">{{ $contract->formatted_number }}</td>
                        <td>
                            <div class="flex items-center gap-2">
                                @if($contract->file_path)
                                    <svg title="Tem arquivo" class="w-4 h-4 text-octa-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"/>
                                    </svg>
                                @endif
                                <a id="link-show-contract-{{ $contract->id }}" href="{{ route('contracts.show', $contract) }}"
                                   class="font-medium text-octa-400 hover:text-octa-300 transition-colors">
                                    {{ $contract->client->name }}
                                </a>
                            </div>
                            @if($contract->client->company_name)
                                <div class="text-xs text-slate-500">{{ $contract->client->company_name }}</div>
                            @endif
                        </td>
                        <td class="font-semibold text-slate-200">R$ {{ number_format($contract->value, 2, ',', '.') }}</td>
                        <td class="text-sm text-slate-400">
                            {{ $contract->start_date->format('d/m/Y') }}
                            @if($contract->end_date)
                                → {{ $contract->end_date->format('d/m/Y') }}
                            @endif
                        </td>
                        <td><x-status-badge :status="$contract->status"/></td>
                        <td>
                            <div class="flex items-center justify-end gap-2">
                                <a id="btn-view-contract-{{ $contract->id }}" href="{{ route('contracts.show', $contract) }}" class="btn-ghost btn-sm">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0zM2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                </a>
                                <a id="btn-edit-contract-{{ $contract->id }}" href="{{ route('contracts.edit', $contract) }}" class="btn-ghost btn-sm">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                </a>
                                <form id="delete-form-contract-{{ $contract->id }}" method="POST" action="{{ route('contracts.destroy', $contract) }}"
                                      x-data @submit.prevent="$dispatch('dialog', { 
                                          title: 'Remover Contrato', 
                                          message: 'Deseja realmente excluir o contrato #{{ $contract->id }}?',
                                          type: 'danger',
                                          onConfirm: () => $el.submit()
                                      })">
                                    @csrf @method('DELETE')
                                    <button id="btn-delete-contract-{{ $contract->id }}" type="submit" class="btn-ghost btn-sm text-red-500 hover:text-red-400">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr id="no-contracts-row">
                        <td colspan="5" class="text-center py-12 text-slate-500">
                            Nenhum contrato encontrado. <a id="link-create-first-contract" href="{{ route('contracts.create') }}" class="text-octa-400 hover:underline">Crie o primeiro.</a>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($contracts->hasPages())
        <div id="contracts-pagination" class="mt-4"> {{ $contracts->links() }}</div>
    @endif

</x-layouts.app>
