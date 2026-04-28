@props(['label', 'icon' => 'circle', 'active' => false])

<div x-data="{ open: {{ $active ? 'true' : 'false' }} }" class="space-y-1">
    <button @click="open = !open" 
            @class([
                'w-full flex items-center justify-between px-3 py-2.5 rounded-lg text-sm font-medium transition-all duration-150',
                'text-octa-400 bg-octa-500/10 border border-octa-500/20' => $active,
                'text-slate-400 hover:text-slate-200 hover:bg-bg-elevated' => !$active,
            ])>
        <div class="flex items-center gap-3">
            <x-nav-item-icon :icon="$icon" class="w-4 h-4" />
            <span>{{ $label }}</span>
        </div>
        <svg class="w-4 h-4 transition-transform duration-200" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
        </svg>
    </button>

    <div x-show="open" 
         x-transition:enter="transition ease-out duration-100"
         x-transition:enter-start="opacity-0 -translate-y-2"
         x-transition:enter-end="opacity-100 translate-y-0"
         class="pl-9 space-y-1 border-l border-bg-border/40 ml-5 mt-1">
        {{ $slot }}
    </div>
</div>
