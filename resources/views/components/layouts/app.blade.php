<!DOCTYPE html>
<html lang="pt-BR" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ isset($title) ? $title . ' — ' : '' }}OctaBit ERP</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-bg-primary min-h-screen flex" x-data="{ sidebarOpen: true }">

    {{-- ── Sidebar ─────────────────────────────────────────────── --}}
    <aside
        class="fixed inset-y-0 left-0 z-30 flex flex-col w-64 bg-bg-secondary border-r border-bg-border
               transition-transform duration-300"
        :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
    >
        {{-- Logo --}}
        <div class="flex items-center gap-3 px-5 h-16 border-b border-bg-border">
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
        <nav class="flex-1 overflow-y-auto px-3 py-4 space-y-1">
            @php
                $current = request()->routeIs(...);
            @endphp

            <x-nav-item href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')" icon="grid">
                Dashboard
            </x-nav-item>

            <div class="pt-4 pb-1 px-3">
                <span class="text-[10px] font-semibold uppercase tracking-widest text-slate-600">CRM</span>
            </div>

            <x-nav-item href="{{ route('leads.index') }}" :active="request()->routeIs('leads.*')" icon="users">
                Leads
            </x-nav-item>

            <x-nav-item href="{{ route('clients.index') }}" :active="request()->routeIs('clients.*')" icon="users">
                Clientes
            </x-nav-item>

            <x-nav-item href="{{ route('deals.index') }}" :active="request()->routeIs('deals.*')" icon="target">
                Oportunidades
            </x-nav-item>

            <x-nav-item href="{{ route('quotes.index') }}" :active="request()->routeIs('quotes.*')" icon="clipboard">
                Orçamentos
            </x-nav-item>

            <div class="pt-4 pb-1 px-3">
                <span class="text-[10px] font-semibold uppercase tracking-widest text-slate-600">Financeiro</span>
            </div>

            <x-nav-item href="{{ route('receivable.index') }}" :active="request()->routeIs('receivable.*')" icon="trending-up">
                Contas a Receber
            </x-nav-item>

            <x-nav-item href="{{ route('payable.index') }}" :active="request()->routeIs('payable.*')" icon="trending-down">
                Contas a Pagar
            </x-nav-item>

            <div class="pt-4 pb-1 px-3">
                <span class="text-[10px] font-semibold uppercase tracking-widest text-slate-600">Operações</span>
            </div>

            <x-nav-item href="{{ route('contracts.index') }}" :active="request()->routeIs('contracts.*')" icon="file-text">
                Contratos
            </x-nav-item>

            <x-nav-item href="{{ route('services.index') }}" :active="request()->routeIs('services.*')" icon="layers">
                Serviços
            </x-nav-item>

            <x-nav-item href="{{ route('products.index') }}" :active="request()->routeIs('products.*')" icon="package">
                Produtos
            </x-nav-item>
        </nav>

        {{-- User info at bottom --}}
        <div class="border-t border-bg-border px-4 py-3">
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
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="text-slate-500 hover:text-red-400 transition-colors" title="Sair">
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
    <div class="flex-1 flex flex-col min-h-screen transition-all duration-300"
         :class="sidebarOpen ? 'ml-64' : 'ml-0'">

        {{-- Topbar --}}
        <header class="sticky top-0 z-20 flex items-center gap-4 h-16 px-6
                        bg-bg-secondary/80 backdrop-blur border-b border-bg-border">

            {{-- Sidebar toggle --}}
            <button @click="sidebarOpen = !sidebarOpen"
                    class="text-slate-400 hover:text-slate-200 transition-colors -ml-1">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>

            {{-- Breadcrumb / page title --}}
            <div class="flex-1">
                @isset($header)
                    <h1 class="text-sm font-semibold text-slate-200">{{ $header }}</h1>
                @endisset
            </div>

            {{-- Right side --}}
            <div class="flex items-center gap-3">
                <span class="text-xs text-slate-500">{{ now()->format('d/m/Y') }}</span>
            </div>
        </header>

        {{-- Flash messages (Nielsen #1 — system status feedback) --}}
        <div class="px-6 pt-4">
            @if (session('success'))
                <div class="alert-success mb-4" x-data x-init="setTimeout(() => $el.remove(), 4000)">
                    <svg class="w-4 h-4 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="alert-error mb-4">
                    <svg class="w-4 h-4 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                    </svg>
                    {{ session('error') }}
                </div>
            @endif
        </div>

        {{-- Page content --}}
        <main class="flex-1 px-6 py-4 pb-8">
            {{ $slot }}
        </main>
    </div>

</body>
</html>
