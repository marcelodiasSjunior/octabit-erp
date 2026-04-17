<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Client;
use App\Models\AccountsReceivable;
use App\Enums\ClientStatus;
use App\Enums\PaymentStatus;
use Illuminate\Database\Seeder;

class ClientSeeder extends Seeder
{
    public function run(): void
    {
        // Sample active clients with receivables
        $clients = Client::factory()->count(5)->active()->create();

        foreach ($clients as $client) {
            AccountsReceivable::factory()->count(3)->create([
                'client_id' => $client->id,
            ]);
        }

        // Some leads (no receivables yet)
        Client::factory()->count(5)->lead()->create();
    }
}
