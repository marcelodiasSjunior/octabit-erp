@props(['href', 'active' => false, 'icon' => 'circle', 'id' => null])

<a href="{{ $href }}" @if($id) id="{{ $id }}" @endif 
    @class([
        'nav-item group',
        'active' => $active
    ])>
    <x-nav-item-icon :icon="$icon" class="w-4 h-4" />
    <span>{{ $slot }}</span>
</a>
