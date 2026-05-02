<x-layouts.app title="Usuários" header="Configurações / Usuários e Permissões">

    {{-- Toolbar --}}
    <div id="users-toolbar" class="flex flex-col sm:flex-row sm:items-center gap-3 mb-6">
        <div class="flex-1">
            <h2 class="text-base font-semibold text-slate-200">Equipe</h2>
            <p class="text-xs text-slate-500">Gerencie os membros da sua equipe e seus níveis de acesso.</p>
        </div>

        <button id="btn-invite-user" class="btn-primary whitespace-nowrap self-start sm:self-auto"
                x-data @click="$dispatch('dialog', { 
                    title: 'Convidar Novo Usuário', 
                    message: 'Esta funcionalidade permitirá enviar um convite por e-mail para um novo membro da equipe.',
                    type: 'confirm',
                    confirmText: 'Entendi'
                })">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
            </svg>
            Novo Usuário
        </button>
    </div>

    {{-- Users Table --}}
    <div id="users-table-wrapper" class="table-wrapper">
        <table id="users-table" class="table">
            <thead>
                <tr>
                    <th>Usuário</th>
                    <th>E-mail</th>
                    <th>Função / Cargo</th>
                    <th>Status</th>
                    <th>Último Acesso</th>
                    <th class="text-right">Ações</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                <tr>
                    <td>
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full bg-octa-500/20 text-octa-400 flex items-center justify-center font-bold text-xs">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                            <div class="font-medium text-slate-200">{{ $user->name }}</div>
                        </div>
                    </td>
                    <td class="text-slate-400">{{ $user->email }}</td>
                    <td>
                        <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider bg-purple-500/10 text-purple-400 border border-purple-500/20">
                            {{ $user->role->label() }}
                        </span>
                    </td>
                    <td>
                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-500/10 text-green-500">
                            Ativo
                        </span>
                    </td>
                    <td class="text-slate-500 text-xs">{{ $user->updated_at?->diffForHumans() ?? '-' }}</td>
                    <td>
                        <div class="flex items-center justify-end gap-2">
                            <a href="{{ route('settings.users.edit', $user) }}" class="btn-ghost btn-sm" title="Editar Permissões">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>
                                </svg>
                            </a>
                            @if($user->id !== auth()->id())
                            <form action="{{ route('settings.users.destroy', $user) }}" method="POST" onsubmit="return confirm('Tem certeza?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-ghost btn-sm text-red-500 hover:text-red-400" title="Remover Acesso">
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
                    <td colspan="6" class="text-center py-8 text-slate-500 italic">Nenhum usuário encontrado.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</x-layouts.app>
