<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\DB;

$duplicates = DB::table('taggables')
    ->select('tag_id', 'taggable_id', 'taggable_type', DB::raw('count(*) as count'))
    ->groupBy('tag_id', 'taggable_id', 'taggable_type')
    ->having('count', '>', 1)
    ->get();

if ($duplicates->isEmpty()) {
    echo "Nenhuma duplicata encontrada em taggables.\n";
} else {
    echo "Duplicatas encontradas em taggables:\n";
    foreach ($duplicates as $dup) {
        echo "Tag ID: {$dup->tag_id} | Taggable ID: {$dup->taggable_id} | Type: {$dup->taggable_type} | Count: {$dup->count}\n";
    }
}

// Check specifically for 'Site Octa' tag
$tag = App\Models\Tag::where('name', 'Site Octa')->first();
if ($tag) {
    $taggables = DB::table('taggables')->where('tag_id', $tag->id)->get();
    echo "\nRegistros em taggables para a tag 'Site Octa' (ID: {$tag->id}):\n";
    foreach ($taggables as $t) {
        echo "ID: " . ($t->id ?? 'N/A') . " | Taggable ID: {$t->taggable_id} | Type: {$t->taggable_type}\n";
    }
}
