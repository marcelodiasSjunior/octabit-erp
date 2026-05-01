<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$tag = App\Models\Tag::where('name', 'like', '%octa%')->first();
if ($tag) {
    echo "Tag: " . $tag->name . "\n";
    $counts = App\Models\Client::whereHas('tags', function($q) use ($tag) {
        $q->where('tags.id', $tag->id);
    })
    ->select('status', Illuminate\Support\Facades\DB::raw('count(*) as total'))
    ->groupBy('status')
    ->get();
    
    foreach ($counts as $c) {
        echo "Status: " . $c->status->value . " - Total: " . $c->total . "\n";
    }

    $clients = App\Models\Client::whereHas('tags', function($q) use ($tag) {
        $q->where('tags.id', $tag->id);
    })->get(['id', 'name', 'status', 'deleted_at']);

    echo "\nDetalhes dos Clientes:\n";
    foreach ($clients as $client) {
        echo "ID: {$client->id} | Nome: {$client->name} | Status: {$client->status->value} | Deletado: " . ($client->deleted_at ? 'Sim' : 'Não') . "\n";
    }
} else {
    echo "Tag nao encontrada";
}
