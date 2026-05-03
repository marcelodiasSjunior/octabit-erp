<!DOCTYPE html>
<html lang="pt-BR" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ isset($title) ? $title . ' — ' : '' }}OctaBit ERP</title>

    {{-- TomSelect --}}
    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/css/tom-select.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/js/tom-select.complete.min.js"></script>

    <script>
        /**
         * Aplica máscaras básicas em inputs.
         */
        window.applyMasks = function(container = document) {
            const documentInputs = container.querySelectorAll('input[name*="cnpj"], input[name*="document"], .mask-document');
            const phoneInputs = container.querySelectorAll('input[name*="phone"], .mask-phone');

            documentInputs.forEach(input => {
                const mask = (val) => {
                    val = val.replace(/\D/g, '');
                    if (val.length <= 11) {
                        return val.replace(/(\d{3})(\d{3})(\d{3})(\d{2})/g, '$1.$2.$3-$4');
                    } else {
                        return val.replace(/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/g, '$1.$2.$3/$4-$5');
                    }
                };
                input.addEventListener('input', (e) => {
                    const start = e.target.selectionStart;
                    const end = e.target.selectionEnd;
                    e.target.value = mask(e.target.value).substring(0, 18);
                    e.target.setSelectionRange(start, end);
                });
                if (input.value) input.value = mask(input.value);
            });

            phoneInputs.forEach(input => {
                const mask = (val) => {
                    val = val.replace(/\D/g, '');
                    if (val.length <= 10) {
                        return val.replace(/(\d{2})(\d{4})(\d{4})/g, '($1) $2-$3');
                    } else {
                        return val.replace(/(\d{2})(\d{5})(\d{4})/g, '($1) $2-$3');
                    }
                };
                input.addEventListener('input', (e) => {
                    const start = e.target.selectionStart;
                    const end = e.target.selectionEnd;
                    e.target.value = mask(e.target.value).substring(0, 15);
                    e.target.setSelectionRange(start, end);
                });
                if (input.value) input.value = mask(input.value);
            });
        };

        document.addEventListener('DOMContentLoaded', () => {
            window.initTomSelect();
            window.applyMasks();
        });
    </script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-bg-primary min-h-screen flex" 
      x-data="{ 
          sidebarOpen: true
      }">

    {{-- ── Sidebar ─────────────────────────────────────────────── --}}
    <aside
        id="sidebar"
        class="fixed inset-y-0 left-0 z-30 flex flex-col w-64 bg-bg-secondary border-r border-bg-border
               transition-all duration-300"
        :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0 lg:w-0 overflow-hidden'"
    >
        {{-- Logo --}}
        <div id="sidebar-logo" class="flex items-center gap-3 px-5 h-16 border-b border-bg-border">
            <div class="w-8 h-8 rounded-lg bg-octa-500 flex items-center justify-center shadow-glow-sm">
                <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/>
                </svg>
            </div>
            <div>
                <span class="text-sm font-bold text-slate-100">OctaBit</span>
                <span class="block text-[10px] text-slate-500 uppercase tracking-widest -mt-0.5">ERP</span>
            </div>
        </div>

        {{-- Navigation --}}
        <nav id="sidebar-nav" class="flex-1 overflow-y-auto px-3 py-4 space-y-1">
            <x-nav-item id="nav-dashboard" href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')" icon="grid">
                Dashboard
            </x-nav-item>

            {{-- CRM --}}
            <x-nav-group icon="users" label="CRM" :active="request()->routeIs('leads.*', 'clients.*', 'deals.*', 'quotes.*', 'tags.*')">
                <x-nav-item href="{{ route('leads.index') }}" :active="request()->routeIs('leads.*')" icon="target">
                    Leads
                </x-nav-item>
                <x-nav-item href="{{ route('clients.index') }}" :active="request()->routeIs('clients.*')" icon="users">
                    Clientes
                </x-nav-item>
                <x-nav-item href="{{ route('deals.index') }}" :active="request()->routeIs('deals.*')" icon="clipboard">
                    Oportunidades
                </x-nav-item>
                <x-nav-item href="{{ route('quotes.index') }}" :active="request()->routeIs('quotes.*')" icon="file-text">
                    Orçamentos
                </x-nav-item>
                <x-nav-item href="{{ route('tags.index') }}" :active="request()->routeIs('tags.*')" icon="tag">
                    Tags / Categorias
                </x-nav-item>
            </x-nav-group>

            {{-- Financeiro --}}
            <x-nav-group icon="trending-down" label="Financeiro" :active="request()->routeIs('receivable.*', 'payable.*')">
                <x-nav-item href="{{ route('receivable.index') }}" :active="request()->routeIs('receivable.*')" icon="circle">
                    Contas a Receber
                </x-nav-item>
                <x-nav-item href="{{ route('payable.index') }}" :active="request()->routeIs('payable.*')" icon="circle">
                    Contas a Pagar
                </x-nav-item>
            </x-nav-group>

            {{-- Relatórios --}}
            <x-nav-group icon="bar-chart-2" label="Relatórios" :active="request()->routeIs('reports.*')">
                <x-nav-item href="{{ route('reports.financial') }}" :active="request()->is('reports/financial*')" icon="trending-up">
                    Financeiro
                </x-nav-item>
                <x-nav-item href="{{ route('reports.quotes') }}" :active="request()->is('reports/quotes*')" icon="file-text">
                    Orçamentos
                </x-nav-item>
            </x-nav-group>

            {{-- Operações --}}
            <x-nav-group icon="layers" label="Operações" :active="request()->routeIs('contracts.*', 'services.*', 'products.*')">
                <x-nav-item href="{{ route('contracts.index') }}" :active="request()->routeIs('contracts.*')" icon="file-text">
                    Contratos
                </x-nav-item>
                <x-nav-item href="{{ route('services.index') }}" :active="request()->routeIs('services.*')" icon="layers">
                    Serviços
                </x-nav-item>
                <x-nav-item href="{{ route('products.index') }}" :active="request()->routeIs('products.*')" icon="package">
                    Produtos
                </x-nav-item>
            </x-nav-group>

            {{-- Admin Master --}}
            @if(auth()->user()->isMasterGlobal())
                <x-nav-group icon="shield" label="Admin Master" :active="request()->routeIs('admin.*')">
                    <x-nav-item href="{{ route('admin.companies.index') }}" :active="request()->routeIs('admin.companies.*')" icon="layout">
                        Empresas
                    </x-nav-item>
                </x-nav-group>
            @endif

            {{-- Configurações --}}
            @if(auth()->user()->isAdminEmpresa() || auth()->user()->isMasterGlobal())
                <x-nav-group icon="settings" label="Configurações" :active="request()->routeIs('settings.*')">
                    <x-nav-item href="{{ route('settings.users.index') }}" :active="request()->routeIs('settings.users.*')" icon="users">
                        Usuários
                    </x-nav-item>
                </x-nav-group>
            @endif
        </nav>

        {{-- User info at bottom --}}
        <div id="sidebar-user-footer" class="border-t border-bg-border px-4 py-3">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-full bg-octa-500/20 border border-octa-500/30 flex items-center justify-center">
                    <span class="text-xs font-semibold text-octa-400">
                        {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                    </span>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium text-slate-200 truncate">{{ auth()->user()->name }}</p>
                    <p class="text-xs text-slate-500 truncate">{{ auth()->user()->role->label() }}</p>
                </div>
                <form id="logout-form" method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button id="btn-logout" type="submit" 
                            @click="Object.keys(localStorage).forEach(k => k.startsWith('nav-group-') && localStorage.removeItem(k))"
                            class="text-slate-500 hover:text-red-400 transition-colors" title="Sair">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                        </svg>
                    </button>
                </form>
            </div>
        </div>
    </aside>

    {{-- ── Main area ───────────────────────────────────────────── --}}
    <div id="main-content" class="flex-1 flex flex-col min-h-screen transition-all duration-300"
         :class="sidebarOpen ? 'ml-64' : 'ml-0'">

        {{-- Topbar --}}
        <header id="topbar" class="sticky top-0 z-20 flex items-center gap-4 h-16 px-6
                        bg-bg-secondary/80 backdrop-blur border-b border-bg-border">

            {{-- Sidebar toggle --}}
            <button id="btn-sidebar-toggle" @click="sidebarOpen = !sidebarOpen"
                    class="text-slate-400 hover:text-slate-200 transition-colors -ml-1">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>

            {{-- Breadcrumb / page title --}}
            <div class="flex-1">
                @isset($header)
                    <h1 id="page-header-title" class="text-sm font-semibold text-slate-200">{{ $header }}</h1>
                @endisset
            </div>

            {{-- Right side --}}
            <div id="topbar-right" class="flex items-center gap-3">
                <span id="current-date" class="text-xs text-slate-500">{{ now()->format('d/m/Y') }}</span>
            </div>
        </header>

        {{-- Page content --}}
        <main class="flex-1 px-6 py-4 pb-8">
            {{-- Alerts --}}
            @if(session('success'))
                <div class="mb-4 p-4 rounded-lg bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 text-sm">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="mb-4 p-4 rounded-lg bg-red-500/10 border border-red-500/20 text-red-400 text-sm">
                    {{ session('error') }}
                </div>
            @endif

            @if($errors->any())
                <div class="mb-4 p-4 rounded-lg bg-red-500/10 border border-red-500/20 text-red-400 text-sm">
                    <ul class="list-disc list-inside">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{ $slot }}
        </main>
    </div>

    <x-toast />
    <x-dialog />

</body>
</html>
