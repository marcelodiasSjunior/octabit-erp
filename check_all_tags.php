<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\DB;

$data = DB::table('taggables')
    ->join('tags', 'tags.id', '=', 'taggables.tag_id')
    ->join('clients', function ($join) {
        $join->on('clients.id', '=', 'taggables.taggable_id')
            ->where('taggables.taggable_type', '=', \App\Models\Client::class);
    })
    ->whereNull('clients.deleted_at')
    ->select('tags.name', 'tags.color', DB::raw('count(*) as total'))
    ->groupBy('tags.id', 'tags.name', 'tags.color')
    ->orderByDesc('total')
    ->get();

echo "Distribuição de Tags (sem filtro de status):\n";
foreach ($data as $row) {
    echo "Tag: {$row->name} | Total: {$row->total}\n";
}

$dataLeads = DB::table('taggables')
    ->join('tags', 'tags.id', '=', 'taggables.tag_id')
    ->join('clients', function ($join) {
        $join->on('clients.id', '=', 'taggables.taggable_id')
            ->where('taggables.taggable_type', '=', \App\Models\Client::class);
    })
    ->whereNull('clients.deleted_at')
    ->where('clients.status', '=', 'lead')
    ->select('tags.name', 'tags.color', DB::raw('count(*) as total'))
    ->groupBy('tags.id', 'tags.name', 'tags.color')
    ->orderByDesc('total')
    ->get();

echo "\nDistribuição de Tags (apenas LEADS):\n";
foreach ($dataLeads as $row) {
    echo "Tag: {$row->name} | Total: {$row->total}\n";
}
