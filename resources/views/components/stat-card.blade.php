@props(['label', 'value', 'icon' => null, 'color' => 'octa', 'sub' => null])

@php
    $colors = [
        'octa'    => 'bg-octa-500/10 text-octa-400',
        'emerald' => 'bg-emerald-500/10 text-emerald-400',
        'blue'    => 'bg-blue-500/10 text-blue-400',
        'yellow'  => 'bg-yellow-500/10 text-yellow-400',
        'red'     => 'bg-red-500/10 text-red-400',
        'cyan'    => 'bg-cyan-500/10 text-cyan-400',
    ];
    $iconClass = $colors[$color] ?? $colors['octa'];
@endphp

<div class="stat-card">
    @if($icon)
        <div class="stat-icon {{ $iconClass }}">
            {!! $icon !!}
        </div>
    @endif
    <div class="flex-1 min-w-0">
        <p class="text-xs text-slate-500 font-medium uppercase tracking-wider">{{ $label }}</p>
        <p class="mt-1 text-2xl font-bold text-slate-100">{{ $value }}</p>
        @if($sub)
            <p class="mt-0.5 text-xs text-slate-500">{{ $sub }}</p>
        @endif
    </div>
</div>
