@props(['type' => 'line', 'height' => 300, 'labels' => [], 'series' => [], 'id' => null, 'colors' => null])

@php
    $id = $id ?? 'chart-' . uniqid();
    $defaultColors = ['#0ea5e9', '#10b981', '#f59e0b', '#ef4444', '#8b5cf6', '#64748b'];
    $chartColors = $colors ?? $defaultColors;
@endphp

<div 
    id="{{ $id }}"
    x-data="{
        labels: {{ json_encode($labels) }},
        series: {{ json_encode($series) }},
        colors: {{ json_encode($chartColors) }},
        init() {
            this.$nextTick(() => {
                const options = {
                    chart: {
                        type: '{{ $type }}',
                        height: {{ $height }},
                        width: '100%',
                        background: 'transparent',
                        toolbar: { show: false },
                        fontFamily: 'Inter, sans-serif',
                        foreColor: '#64748b',
                        animations: {
                            enabled: true,
                            easing: 'easeinout',
                            speed: 800,
                        },
                        redrawOnParentResize: true
                    },
                    series: this.series,
                    labels: this.labels,
                    stroke: { curve: 'smooth', width: 2 },
                    grid: { 
                        borderColor: '#1e293b', 
                        strokeDashArray: 4,
                        padding: {
                            left: 10,
                            right: 10
                        }
                    },
                    theme: { mode: 'dark' },
                    colors: this.colors,
                    tooltip: { theme: 'dark' },
                    legend: { position: 'bottom' },
                    dataLabels: { enabled: false }
                };

                const chart = new ApexCharts(this.$el, options);
                chart.render().then(() => {
                    // Forçar um resize rápido para garantir o alinhamento perfeito
                    setTimeout(() => window.dispatchEvent(new Event('resize')), 100);
                });
            });
        }
    }"
    {{ $attributes->merge(['class' => 'w-full overflow-hidden']) }}
>
</div>
