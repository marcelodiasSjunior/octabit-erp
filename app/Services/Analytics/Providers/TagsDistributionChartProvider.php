<?php

namespace App\Services\Analytics\Providers;

use App\Services\Analytics\Contracts\ChartProviderInterface;
use App\Models\Tag;
use Illuminate\Support\Facades\DB;

class TagsDistributionChartProvider implements ChartProviderInterface
{
    public function get(): array
    {
        // Contagem de associações por tag
        $data = DB::table('taggables')
            ->join('tags', 'tags.id', '=', 'taggables.tag_id')
            ->select('tags.name', 'tags.color', DB::raw('count(*) as total'))
            ->groupBy('tags.id', 'tags.name', 'tags.color')
            ->orderByDesc('total')
            ->limit(5)
            ->get();

        return [
            'labels' => $data->pluck('name')->toArray(),
            'series' => $data->pluck('total')->map(fn($val) => (int)$val)->toArray(),
            'colors' => $data->pluck('color')->toArray(),
        ];
    }
}
