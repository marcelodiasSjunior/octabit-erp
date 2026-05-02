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
                {{-- Mocked Data --}}
                <tr>
                    <td>
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full bg-octa-500/20 text-octa-400 flex items-center justify-center font-bold text-xs">
                                M
                            </div>
                            <div class="font-medium text-slate-200">Marcelo</div>
                        </div>
                    </td>
                    <td class="text-slate-400">marcelo@octabit.tech</td>
                    <td>
                        <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider bg-purple-500/10 text-purple-400 border border-purple-500/20">
                            Administrador
                        </span>
                    </td>
                    <td>
                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-500/10 text-green-500">
                            Ativo
                        </span>
                    </td>
                    <td class="text-slate-500 text-xs">Hoje, 14:20</td>
                    <td>
                        <div class="flex items-center justify-end gap-2">
                            <button class="btn-ghost btn-sm" title="Editar Permissões">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>
                                </svg>
                            </button>
                            <button class="btn-ghost btn-sm text-red-500 hover:text-red-400" title="Remover Acesso">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                            </button>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full bg-slate-700 text-slate-300 flex items-center justify-center font-bold text-xs">
                                J
                            </div>
                            <div class="font-medium text-slate-200">João Vendedor</div>
                        </div>
                    </td>
                    <td class="text-slate-400">joao@octabit.tech</td>
                    <td>
                        <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider bg-blue-500/10 text-blue-400 border border-blue-500/20">
                            Vendedor
                        </span>
                    </td>
                    <td>
                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-500/10 text-green-500">
                            Ativo
                        </span>
                    </td>
                    <td class="text-slate-500 text-xs">Ontem, 09:15</td>
                    <td>
                        <div class="flex items-center justify-end gap-2">
                            <button class="btn-ghost btn-sm" title="Editar Permissões">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>
                                </svg>
                            </button>
                            <button class="btn-ghost btn-sm text-red-500 hover:text-red-400" title="Remover Acesso">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                            </button>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

</x-layouts.app>
