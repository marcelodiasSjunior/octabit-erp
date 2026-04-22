@props(['href', 'active' => false, 'icon' => 'circle'])

@php
    $iconPaths = [
        'grid'         => 'M3 3h7v7H3zm11 0h7v7h-7zM3 14h7v7H3zm11 0h7v7h-7z',
        'users'        => 'M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2M23 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75M9 11a4 4 0 1 0 0-8 4 4 0 0 0 0 8z',
        'trending-up'  => 'M23 6l-9.5 9.5-5-5L1 18M17 6h6v6',
        'trending-down'=> 'M23 18l-9.5-9.5-5 5L1 6M17 18h6v-6',
        'file-text'    => 'M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8zM14 2v6h6M16 13H8M16 17H8M10 9H8',
        'layers'       => 'M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5',
        'package'      => 'M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16zM3.27 6.96L12 12.01l8.73-5.05M12 22.08V12',
        'target'       => 'M12 2a10 10 0 1 0 0 20 10 10 0 0 0 0-20zM12 6a6 6 0 1 1 0 12 6 6 0 0 1 0-12zM12 9a3 3 0 1 0 0 6 3 3 0 0 0 0-6z',
        'circle'       => 'M12 22a10 10 0 1 0 0-20 10 10 0 0 0 0 20z',
        'clipboard'    => 'M9 5H7a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-2M9 5a2 2 0 0 0 2 2h2a2 2 0 0 0 2-2M9 5a2 2 0 1 1 4 0M9 12h6M9 16h4',
    ];
    $path = $iconPaths[$icon] ?? $iconPaths['circle'];
@endphp

<a href="{{ $href }}" @class(['nav-item', 'active' => $active])>
    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $path }}"/>
    </svg>
    <span>{{ $slot }}</span>
</a>
