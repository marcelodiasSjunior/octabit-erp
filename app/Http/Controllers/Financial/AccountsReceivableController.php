<?php

declare(strict_types=1);

namespace App\Http\Controllers\Financial;

use App\Http\Controllers\Controller;
use App\Services\FinancialService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

final class AccountsReceivableController extends Controller
{
    public function __construct(
        private readonly FinancialService $service
    ) {}

    public function index(Request $request): View
    {
        $filters    = $request->only(['status', 'client_id', 'month', 'year']);
        $receivables = $this->service->listReceivable($filters);

        return view('financial.receivable.index', compact('receivables', 'filters'));
    }

    public function create(): View
    {
        return view('financial.receivable.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'client_id'   => 'required|exists:clients,id',
            'description' => 'required|string|max:255',
            'amount'      => 'required|numeric|min:0.01',
            'due_date'    => 'required|date',
            'notes'       => 'nullable|string|max:1000',
        ]);

        $this->service->createReceivable($validated);

        return redirect()
            ->route('receivable.index')
            ->with('success', 'Cobrança criada com sucesso.');
    }

    public function markAsPaid(Request $request, int $id): RedirectResponse
    {
        $validated = $request->validate([
            'payment_date' => 'required|date',
        ]);

        $this->service->markReceivableAsPaid($id, $validated['payment_date']);

        return back()->with('success', 'Pagamento registrado com sucesso.');
    }

    public function destroy(int $id): RedirectResponse
    {
        $this->service->deleteReceivable($id);

        return redirect()
            ->route('receivable.index')
            ->with('success', 'Cobrança cancelada.');
    }
}
