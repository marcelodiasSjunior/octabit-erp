@props(['type' => 'line', 'height' => 300, 'labels' => [], 'series' => [], 'id' => null])

@php
    $id = $id ?? 'chart-' . uniqid();
@endphp

<div 
    id="{{ $id }}"
    x-data="{
        labels: {{ json_encode($labels) }},
        series: {{ json_encode($series) }},
        init() {
            const options = {
                chart: {
                    type: '{{ $type }}',
                    height: {{ $height }},
                    toolbar: { show: false },
                    fontFamily: 'Inter, sans-serif',
                    foreColor: '#64748b'
                },
                series: this.series,
                labels: this.labels,
                stroke: { curve: 'smooth', width: 2 },
                grid: { borderColor: '#1e293b', strokeDashArray: 4 },
                theme: { mode: 'dark' },
                colors: ['#0ea5e9', '#10b981', '#f59e0b', '#ef4444'],
                tooltip: { theme: 'dark' }
            };

            const chart = new ApexCharts(this.$el, options);
            chart.render();
        }
    }"
    {{ $attributes->merge(['class' => 'w-full']) }}
>
</div>
