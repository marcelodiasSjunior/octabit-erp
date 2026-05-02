<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\ClientService;
use App\Services\ProductCatalogService;
use App\Services\ServiceCatalogService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

final class SearchController extends Controller
{
    public function __construct(
        private readonly ClientService         $clientService,
        private readonly ProductCatalogService $productService,
        private readonly ServiceCatalogService $serviceCatalogService
    ) {}

    public function clients(Request $request): JsonResponse
    {
        $clients = $this->clientService->searchClients($request->get('q'));

        return response()->json($clients->map(function($client) {
            return [
                'id' => $client->id,
                'text' => $client->display_name . ($client->formatted_document ? " ({$client->formatted_document})" : '')
            ];
        }));
    }

    public function leads(Request $request): JsonResponse
    {
        $leads = $this->clientService->searchLeads($request->get('q'));

        return response()->json($leads->map(function($lead) {
            return [
                'id' => $lead->id,
                'text' => $lead->display_name . ($lead->formatted_document ? " ({$lead->formatted_document})" : '')
            ];
        }));
    }

    public function all(Request $request): JsonResponse
    {
        $clients = $this->clientService->searchAllEligible($request->get('q'));

        return response()->json($clients->map(function($client) {
            return [
                'id' => $client->id,
                'text' => $client->display_name . " (" . $client->status->label() . ")" . ($client->formatted_document ? " - {$client->formatted_document}" : '')
            ];
        }));
    }

    public function products(Request $request): JsonResponse
    {
        $products = $this->productService->searchProducts($request->get('q'));

        return response()->json($products->map(function($p) {
            return [
                'id' => $p->id,
                'text' => $p->name . ($p->sku ? " [{$p->sku}]" : '') . " - R$ " . number_format((float)$p->price, 2, ',', '.'),
                'price' => (float)$p->price,
                'description' => $p->description
            ];
        }));
    }

    public function services(Request $request): JsonResponse
    {
        $services = $this->serviceCatalogService->searchServices($request->get('q'));

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
