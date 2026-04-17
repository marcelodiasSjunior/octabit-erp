<?php

declare(strict_types=1);

namespace App\Http\Controllers\Client;

use App\DTOs\Client\CreateClientDTO;
use App\DTOs\Client\UpdateClientDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Client\StoreClientRequest;
use App\Http\Requests\Client\UpdateClientRequest;
use App\Models\Product;
use App\Models\Service;
use App\Services\ClientService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

final class ClientController extends Controller
{
    public function __construct(
        private readonly ClientService $service
    ) {}

    public function index(Request $request): View
    {
        $filters = $request->only(['status', 'search']);
        $clients = $this->service->list($filters);

        return view('clients.index', compact('clients', 'filters'));
    }

    public function create(): View
    {
        return view('clients.create');
    }

    public function store(StoreClientRequest $request): RedirectResponse
    {
        $dto    = CreateClientDTO::fromArray($request->validated());
        $client = $this->service->create($dto);

        return redirect()
            ->route('clients.index')
            ->with('success', "Cliente \"{$client->name}\" criado com sucesso.");
    }

    public function show(int $id): View
    {
        $client = $this->service->findOrFail($id);
        $client->load([
            'clientServices.service',
            'clientProducts.product',
            'interactions.user',
            'contracts',
        ]);

        $availableServices = Service::active()->orderBy('name')->get();
        $availableProducts = Product::active()->orderBy('name')->get();

        return view('clients.show', compact('client', 'availableServices', 'availableProducts'));
    }

    public function edit(int $id): View
    {
        $client = $this->service->findOrFail($id);

        return view('clients.edit', compact('client'));
    }

    public function update(UpdateClientRequest $request, int $id): RedirectResponse
    {
        $dto    = UpdateClientDTO::fromArray($request->validated());
        $client = $this->service->update($id, $dto);

        return redirect()
            ->route('clients.show', $client)
            ->with('success', 'Cliente atualizado com sucesso.');
    }

    public function destroy(int $id): RedirectResponse
    {
        $this->authorize('delete-client');

        $this->service->delete($id);

        return redirect()
            ->route('clients.index')
            ->with('success', 'Cliente removido.');
    }
}
