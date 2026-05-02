<x-layouts.app title="Empresas" header="Administração Global / Empresas">

    {{-- Toolbar --}}
    <div id="companies-toolbar" class="flex flex-col sm:flex-row sm:items-center gap-3 mb-6">
        {{-- Search / filters --}}
        <form method="GET" action="#" class="flex flex-1 flex-col sm:flex-row gap-3" id="filter-form">
            <input
                id="input-search"
                type="search"
                name="search"
                value="{{ request('search') }}"
                placeholder="Buscar empresa por nome, CNPJ, e-mail..."
                class="input flex-1 max-w-sm"
            />

            <select id="select-status" name="status" class="ajax-select w-auto">
                <option value="">Todos os Status</option>
                <option value="active">Ativas</option>
                <option value="inactive">Inativas</option>
                <option value="trial">Trial</option>
            </select>

            <button type="submit" class="btn-secondary">Filtrar</button>
        </form>

        <a id="btn-create-company" href="#" class="btn-primary whitespace-nowrap self-start sm:self-auto">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Nova Empresa
        </a>
    </div>

    {{-- Table --}}
    <div id="companies-table-wrapper" class="table-wrapper">
        <table id="companies-table" class="table">
            <thead>
                <tr>
                    <th>Empresa</th>
                    <th>Documento</th>
                    <th>Plano / Status</th>
                    <th>Admin Responsável</th>
                    <th>Criado em</th>
                    <th class="text-right">Ações</th>
                </tr>
            </thead>
            <tbody>
                {{-- Mocked Data --}}
                <tr>
                    <td>
                        <div class="font-medium text-slate-200">Octabit Tech</div>
                        <div class="text-xs text-slate-500">octabit.tech</div>
                    </td>
                    <td class="font-mono text-xs">00.000.000/0001-00</td>
                    <td>
                        <div class="flex flex-col gap-1">
                            <span class="text-xs font-semibold text-octa-400 uppercase tracking-wider">Premium</span>
                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-500/10 text-green-500 w-fit">Ativa</span>
                        </div>
                    </td>
                    <td>
                        <div class="text-sm text-slate-300">Marcelo</div>
                        <div class="text-xs text-slate-500">marcelo@octabit.tech</div>
                    </td>
                    <td class="text-slate-400 text-xs">01/05/2026</td>
                    <td>
                        <div class="flex items-center justify-end gap-2">
                            <a href="#" class="btn-ghost btn-sm" title="Configurações">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                            </a>
                            <a href="#" class="btn-ghost btn-sm" title="Logar como">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                                </svg>
                            </a>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

</x-layouts.app>
