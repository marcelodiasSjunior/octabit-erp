@props(['tag'])

@php
    $color = $tag->color ?? '#cbd5e1';
    // Ensure hex starts with #
    if (strpos($color, '#') !== 0) {
        $color = '#' . $color;
    }
@endphp

<span 
    {{ $attributes->merge(['class' => 'inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium border transition-all truncate max-w-[120px]']) }}
    style="background-color: {{ $color }}15; color: {{ $color }}; border-color: {{ $color }}30;"
    title="{{ $tag->name }}"
>
    <span class="w-1.5 h-1.5 rounded-full mr-1.5" style="background-color: {{ $color }};"></span>
    {{ $tag->name }}
</span>
