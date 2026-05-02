<?php

declare(strict_types=1);

namespace App\Http\Controllers\Quote;

use App\DTOs\Quote\CreateQuoteDTO;
use App\DTOs\Quote\UpdateQuoteDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Quote\StoreQuoteRequest;
use App\Http\Requests\Quote\UpdateQuoteRequest;
use App\Services\ClientService;
use App\Services\ProductCatalogService;
use App\Services\QuoteService;
use App\Services\ServiceCatalogService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

final class QuoteController extends Controller
{
    public function __construct(
        private readonly QuoteService          $service,
        private readonly ClientService         $clientService,
        private readonly ProductCatalogService $productService,
        private readonly ServiceCatalogService $serviceCatalogService
    ) {}

    public function index(Request $request): View
    {
        $filters = $request->only(['status', 'search']);
        $quotes  = $this->service->list($filters);

        return view('quotes.index', compact('quotes', 'filters'));
    }

    public function create(): View
    {
        $clients  = $this->clientService->getEligibleForDeals();
        $products = $this->productService->allActive();
        $services = $this->serviceCatalogService->allActive();

        return view('quotes.create', compact('clients', 'products', 'services'));
    }

    public function store(StoreQuoteRequest $request): RedirectResponse
    {
        $dto   = CreateQuoteDTO::fromArray($request->validated());
        $quote = $this->service->create($dto);

        return redirect()->route('quotes.show', $quote->id)
            ->with('success', "Orçamento #{$quote->id} criado com sucesso.");
    }

    public function show(int $id): View
    {
        $quote = $this->service->findOrFail($id);

        return view('quotes.show', compact('quote'));
    }

    public function edit(int $id): View
    {
        $quote    = $this->service->findOrFail($id);
        $clients  = $this->clientService->getEligibleForDeals();
        $products = $this->productService->allActive();
        $services = $this->serviceCatalogService->allActive();

        return view('quotes.edit', compact('quote', 'clients', 'products', 'services'));
    }

    public function update(UpdateQuoteRequest $request, int $id): RedirectResponse
    {
        $dto   = UpdateQuoteDTO::fromArray($request->validated());
        $quote = $this->service->update($id, $dto);

        return redirect()->route('quotes.show', $quote->id)
            ->with('success', 'Orçamento atualizado com sucesso.');
    }

    public function destroy(int $id): RedirectResponse
    {
        $this->service->delete($id);

        return redirect()->route('quotes.index')
            ->with('success', 'Orçamento removido.');
    }

    public function send(int $id): RedirectResponse
    {
        try {
            $quote = $this->service->markAsSent($id);
            return back()->with('success', "Orçamento #{$quote->id} marcado como enviado.");
        } catch (ValidationException $e) {
            return back()->withErrors($e->errors());
        }
    }

    public function approve(int $id): RedirectResponse
    {
        try {
            $quote = $this->service->approve($id);
            return back()->with('success', "Orçamento #{$quote->id} aprovado.");
        } catch (ValidationException $e) {
            return back()->withErrors($e->errors());
        }
    }

    public function reject(int $id): RedirectResponse
    {
        try {
            $quote = $this->service->reject($id);
            return back()->with('success', "Orçamento #{$quote->id} rejeitado.");
        } catch (ValidationException $e) {
            return back()->withErrors($e->errors());
        }
    }
}
