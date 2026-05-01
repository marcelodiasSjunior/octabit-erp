<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Client;
use App\Enums\ClientStatus;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

final class SearchController extends Controller
{
    /**
     * Search for active clients.
     */
    public function clients(Request $request): JsonResponse
    {
        $query = $request->get('q');
        \Illuminate\Support\Facades\Log::info('[SearchController] Buscando clientes', ['q' => $query]);
        
        $clients = Client::where('status', ClientStatus::Active)
            ->where(function($q) use ($query) {
                $q->where('name', 'like', "%{$query}%")
                  ->orWhere('company_name', 'like', "%{$query}%")
                  ->orWhere('document', 'like', "%{$query}%");
            })
            ->limit(20)
            ->get();

        \Illuminate\Support\Facades\Log::info('[SearchController] Clientes encontrados', ['count' => $clients->count()]);

        return response()->json($clients->map(function($client) {
            return [
                'id' => $client->id,
                'text' => $client->display_name . ($client->formatted_document ? " ({$client->formatted_document})" : '')
            ];
        }));
    }

    /**
     * Search for leads.
     */
    public function leads(Request $request): JsonResponse
    {
        $query = $request->get('q');
        \Illuminate\Support\Facades\Log::info('[SearchController] Buscando leads', ['q' => $query]);
        
        $leads = Client::where('status', ClientStatus::Lead)
            ->where(function($q) use ($query) {
                $q->where('name', 'like', "%{$query}%")
                  ->orWhere('company_name', 'like', "%{$query}%")
                  ->orWhere('document', 'like', "%{$query}%");
            })
            ->limit(20)
            ->get();

        \Illuminate\Support\Facades\Log::info('[SearchController] Leads encontrados', ['count' => $leads->count()]);

        return response()->json($leads->map(function($lead) {
            return [
                'id' => $lead->id,
                'text' => $lead->display_name . ($lead->formatted_document ? " ({$lead->formatted_document})" : '')
            ];
        }));
    }

    /**
     * Search for leads or active clients.
     */
    public function all(Request $request): JsonResponse
    {
        $query = $request->get('q');
        \Illuminate\Support\Facades\Log::info('[SearchController] Buscando todos (Leads/Ativos)', ['q' => $query]);
        
        $clients = Client::whereIn('status', [ClientStatus::Lead->value, ClientStatus::Active->value])
            ->where(function($q) use ($query) {
                $q->where('name', 'like', "%{$query}%")
                  ->orWhere('company_name', 'like', "%{$query}%")
                  ->orWhere('document', 'like', "%{$query}%");
            })
            ->limit(20)
            ->get();

        \Illuminate\Support\Facades\Log::info('[SearchController] Total encontrado (all)', ['count' => $clients->count()]);

        return response()->json($clients->map(function($client) {
            return [
                'id' => $client->id,
                'text' => $client->display_name . " (" . $client->status->label() . ")" . ($client->formatted_document ? " - {$client->formatted_document}" : '')
            ];
        }));
    }

    /**
     * Search for products.
     */
    public function products(Request $request): JsonResponse
    {
        $query = $request->get('q');
        
        $products = \App\Models\Product::where('name', 'like', "%{$query}%")
            ->orWhere('sku', 'like', "%{$query}%")
            ->limit(20)
            ->get();

        return response()->json($products->map(function($p) {
            return [
                'id' => $p->id,
                'text' => $p->name . ($p->sku ? " [{$p->sku}]" : '') . " - R$ " . number_format((float)$p->price, 2, ',', '.'),
                'price' => (float)$p->price,
                'description' => $p->description
            ];
        }));
    }

    /**
     * Search for services.
     */
    public function services(Request $request): JsonResponse
    {
        $query = $request->get('q');
        
        $services = \App\Models\Service::where('name', 'like', "%{$query}%")
            ->limit(20)
            ->get();

        return response()->json($services->map(function($s) {
            return [
                'id' => $s->id,
                'text' => $s->name . " - R$ " . number_format((float)$s->price, 2, ',', '.'),
                'price' => (float)$s->price,
                'description' => $s->description
            ];
        }));
    }
}
