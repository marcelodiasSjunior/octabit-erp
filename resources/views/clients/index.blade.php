<x-layouts.app title="Clientes" header="Clientes">

    {{-- Toolbar --}}
    <div class="flex flex-col sm:flex-row sm:items-center gap-3 mb-6">
        {{-- Search / filters --}}
        <form method="GET" action="{{ route('clients.index') }}"
              class="flex flex-1 flex-col sm:flex-row gap-3" id="filter-form">

            <input
                type="search"
                name="search"
                value="{{ $filters['search'] ?? '' }}"
                placeholder="Buscar por nome, empresa, e-mail, documento..."
                class="input flex-1 max-w-sm"
            />

            <select name="status" class="select w-auto" onchange="document.getElementById('filter-form').submit()">
                <option value="">Todos os status</option>
                @foreach(\App\Enums\ClientStatus::cases() as $status)
                    <option value="{{ $status->value }}"
                        {{ ($filters['status'] ?? '') === $status->value ? 'selected' : '' }}>
                        {{ $status->label() }}
                    </option>
                @endforeach
            </select>

            @if(!empty($filters['search']) || !empty($filters['status']))
                <a href="{{ route('clients.index') }}" class="btn-ghost btn-sm self-center">
                    Limpar
                </a>
            @endif
        </form>

        <a href="{{ route('clients.create') }}" class="btn-primary whitespace-nowrap self-start sm:self-auto">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Novo Cliente
        </a>
    </div>

    {{-- Table --}}
    <div class="table-wrapper">
        <table class="table">
            <thead>
                <tr>
                    <th>Nome / Empresa</th>
                    <th>Documento</th>
                    <th>E-mail</th>
                    <th>Telefone</th>
                    <th>Status</th>
                    <th class="text-right">Ações</th>
                </tr>
            </thead>
            <tbody>
                @forelse($clients as $client)
                    <tr>
                        <td>
                            <div class="font-medium text-slate-200">{{ $client->name }}</div>
                            @if($client->company_name)
                                <div class="text-xs text-slate-500">{{ $client->company_name }}</div>
                            @endif
                        </td>
                        <td class="font-mono text-xs">{{ $client->formatted_document }}</td>
                        <td class="text-slate-400">{{ $client->email }}</td>
                        <td class="text-slate-400 text-xs">{{ $client->phone ?? '—' }}</td>
                        <td><x-status-badge :status="$client->status"/></td>
                        <td>
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('clients.show', $client) }}"
                                   class="btn-ghost btn-sm" title="Ver detalhes">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0zM2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                </a>
                                <a href="{{ route('clients.edit', $client) }}"
                                   class="btn-ghost btn-sm" title="Editar">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                </a>

                                @if(auth()->user()->isAdmin())
                                    <form method="POST" action="{{ route('clients.destroy', $client) }}"
                                          x-data
                                          @submit.prevent="if(confirm('Remover {{ addslashes($client->name) }}?')) $el.submit()">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-ghost btn-sm text-red-500 hover:text-red-400" title="Remover">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-12 text-slate-500">
                            <svg class="w-10 h-10 mx-auto mb-3 opacity-40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            Nenhum cliente encontrado.
                            <a href="{{ route('clients.create') }}" class="text-octa-400 hover:text-octa-300 ml-1">Criar o primeiro?</a>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    @if($clients->hasPages())
        <div class="mt-4">
            {{ $clients->withQueryString()->links('pagination::tailwind') }}
        </div>
    @endif

</x-layouts.app>
