<?php

declare(strict_types=1);

namespace App\Http\Controllers\Quote;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Product;
use App\Models\Service;
use App\Services\QuoteService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

final class QuoteController extends Controller
{
    public function __construct(
        private readonly QuoteService $service
    ) {}

    public function index(Request $request): View
    {
        $filters = $request->only(['status', 'search']);
        $quotes  = $this->service->list($filters);

        return view('quotes.index', compact('quotes', 'filters'));
    }

    public function create(): View
    {
        $clients  = Client::orderBy('name')->get(['id', 'name']);
        $products = Product::active()->orderBy('name')->get(['id', 'name', 'price']);
        $services = Service::active()->orderBy('name')->get(['id', 'name', 'base_price']);

        return view('quotes.create', compact('clients', 'products', 'services'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'client_id'           => ['required', 'exists:clients,id'],
            'valid_until'         => ['required', 'date', 'after:today'],
            'items'               => ['required', 'array', 'min:1'],
            'items.*.description' => ['required', 'string', 'max:255'],
            'items.*.quantity'    => ['required', 'numeric', 'min:0.0001'],
            'items.*.unit_price'  => ['required', 'numeric', 'min:0'],
            'items.*.discount'    => ['nullable', 'numeric', 'min:0'],
            'items.*.product_id'  => ['nullable', 'exists:products,id'],
            'items.*.service_id'  => ['nullable', 'exists:services,id'],
        ]);

        $quote = $this->service->create($data);

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
        $clients  = Client::orderBy('name')->get(['id', 'name']);
        $products = Product::active()->orderBy('name')->get(['id', 'name', 'price']);
        $services = Service::active()->orderBy('name')->get(['id', 'name', 'base_price']);

        return view('quotes.edit', compact('quote', 'clients', 'products', 'services'));
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $data = $request->validate([
            'client_id'           => ['required', 'exists:clients,id'],
            'valid_until'         => ['required', 'date'],
            'items'               => ['required', 'array', 'min:1'],
            'items.*.description' => ['required', 'string', 'max:255'],
            'items.*.quantity'    => ['required', 'numeric', 'min:0.0001'],
            'items.*.unit_price'  => ['required', 'numeric', 'min:0'],
            'items.*.discount'    => ['nullable', 'numeric', 'min:0'],
            'items.*.product_id'  => ['nullable', 'exists:products,id'],
            'items.*.service_id'  => ['nullable', 'exists:services,id'],
        ]);

        $quote = $this->service->update($id, $data);

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
