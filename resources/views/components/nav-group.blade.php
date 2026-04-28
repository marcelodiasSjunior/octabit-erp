@props(['label', 'icon' => 'circle', 'active' => false])

@php
    $id = 'nav-group-' . \Illuminate\Support\Str::slug($label);
@endphp

<div x-data="{ 
    open: @js($active) || localStorage.getItem('{{ $id }}') === 'true',
    toggle() {
        this.open = !this.open;
        localStorage.setItem('{{ $id }}', this.open);
    }
}" class="w-full">
    <button @click="toggle()" 
            @class([
                'w-full flex items-center justify-between px-3 py-2 rounded-lg text-sm transition-all duration-150 group',
                'text-octa-400 bg-octa-500/5' => $active,
                'text-slate-400 hover:text-slate-200 hover:bg-bg-elevated' => !$active,
            ])
            :aria-expanded="open">
        <div class="flex items-center gap-2.5">
            <x-nav-item-icon :icon="$icon" @class([
                'w-4 h-4 transition-colors',
                'text-octa-400' => $active,
                'text-slate-500 group-hover:text-slate-300' => !$active
            ]) />
            <span class="truncate font-medium">{{ $label }}</span>
        </div>
        <svg class="w-3.5 h-3.5 transition-transform duration-300 text-slate-600 group-hover:text-slate-400" 
             :class="open ? 'rotate-180' : ''" 
             fill="none" 
             stroke="currentColor" 
             viewBox="0 0 24 24">
            <path d="M19 9l-7 7-7-7" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
    </button>

    <div x-show="open" 
         x-collapse
         x-cloak
         class="ml-4 mt-0.5 border-l border-bg-border/50 pl-2 space-y-0.5">
        {{ $slot }}
    </div>
</div>
