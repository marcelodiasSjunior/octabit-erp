<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$ids = [5, 12, 13];
foreach ($ids as $id) {
    $client = App\Models\Client::find($id);
    if ($client) {
        echo "ID: {$client->id} | Nome: {$client->name} | Status: {$client->status->value} | Deletado: " . ($client->deleted_at ? 'Sim' : 'Não') . "\n";
    } else {
        $clientDeleted = App\Models\Client::withTrashed()->find($id);
        if ($clientDeleted) {
            echo "ID: {$clientDeleted->id} | Nome: {$clientDeleted->name} | Status: {$clientDeleted->status->value} | Deletado: SIM (Soft Deleted)\n";
        } else {
            echo "ID: {$id} | Não encontrado nem no lixo.\n";
        }
    }
}
