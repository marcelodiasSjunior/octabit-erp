@props(['href', 'active' => false, 'icon' => 'circle', 'id' => null])

<a href="{{ $href }}" @if($id) id="{{ $id }}" @endif 
    @class([
        'flex items-center gap-2.5 px-3 py-2 rounded-lg text-sm transition-all duration-150 group',
        'text-octa-400 bg-octa-500/5 font-medium' => $active,
        'text-slate-400 hover:text-slate-200 hover:bg-bg-elevated' => !$active
    ])>
    <x-nav-item-icon :icon="$icon" @class([
        'w-4 h-4 transition-colors',
        'text-octa-400' => $active,
        'text-slate-500 group-hover:text-slate-300' => !$active
    ]) />
    <span class="truncate">{{ $slot }}</span>
</a>
