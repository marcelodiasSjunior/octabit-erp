<?php

declare(strict_types=1);

namespace App\Http\Controllers\Client;

use App\DTOs\Client\CreateClientDTO;
use App\DTOs\Client\UpdateClientDTO;
use App\Enums\ClientStatus;
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
        return $this->renderIndex($request, 'clients');
    }

    public function leads(Request $request): View
    {
        return $this->renderIndex($request, 'leads');
    }

    private function renderIndex(Request $request, string $segment): View
    {
        $filters = $request->only(['status', 'search', 'tag_id']);
        $filters['segment'] = $segment;
        $clients = $this->service->list($filters);
        $tags = \App\Models\Tag::orderBy('name')->get();

        return view('clients.index', compact('clients', 'filters', 'segment', 'tags'));
    }

    public function create(): View
    {
        $tags = \App\Models\Tag::orderBy('name')->get();
        return view('clients.create', [
            'segment' => 'clients',
            'tags'    => $tags,
        ]);
    }

    public function createLead(): View
    {
        $tags = \App\Models\Tag::orderBy('name')->get();
        return view('clients.create', [
            'segment' => 'leads',
            'tags'    => $tags,
        ]);
    }

    public function store(StoreClientRequest $request): RedirectResponse
    {
        $dto    = CreateClientDTO::fromArray($request->validated());
        $client = $this->service->create($dto);

        $redirectRoute = $client->status === ClientStatus::Lead ? 'leads.index' : 'clients.index';
        $entityName = $client->status === ClientStatus::Lead ? 'Lead' : 'Cliente';

        return redirect()
            ->route($redirectRoute)
            ->with('success', "{$entityName} \"{$client->name}\" criado com sucesso.");
    }

    public function storeLead(StoreClientRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $validated['status'] = ClientStatus::Lead->value;

        $dto = CreateClientDTO::fromArray($validated);
        $lead = $this->service->create($dto);

        return redirect()
            ->route('leads.index')
            ->with('success', "Lead \"{$lead->name}\" criado com sucesso.");
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

    public function edit(Request $request, int $id): View
    {
        $client = $this->service->findOrFail($id);
        $tags = \App\Models\Tag::orderBy('name')->get();

        $segment = $request->query('segment');
        if (!in_array($segment, ['leads', 'clients'], true)) {
            $segment = $client->status === ClientStatus::Lead ? 'leads' : 'clients';
        }

        return view('clients.edit', compact('client', 'segment', 'tags'));
    }

    public function update(UpdateClientRequest $request, int $id): RedirectResponse
    {
        $before = $this->service->findOrFail($id);
        $dto    = UpdateClientDTO::fromArray($request->validated());
        $client = $this->service->update($id, $dto);

        if ($before->status === ClientStatus::Lead && $client->status !== ClientStatus::Lead) {
            return redirect()
                ->route('clients.index')
                ->with('success', 'Lead convertido para cliente com sucesso.');
        }

        if ($client->status === ClientStatus::Lead) {
            return redirect()
                ->route('leads.index')
                ->with('success', 'Lead atualizado com sucesso.');
        }

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
