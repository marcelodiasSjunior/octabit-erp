<?php

declare(strict_types=1);

namespace App\Http\Controllers\Financial;

use App\Http\Controllers\Controller;
use App\Services\PayableService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

final class AccountsPayableController extends Controller
{
    public function __construct(
        private readonly PayableService $service
    ) {}

    public function index(Request $request): View
    {
        $filters  = $request->only(['status', 'category', 'month', 'year']);
        $payables = $this->service->list($filters);

        return view('financial.payable.index', compact('payables', 'filters'));
    }

    public function create(): View
    {
        return view('financial.payable.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'description' => 'required|string|max:255',
            'amount'      => 'required|numeric|min:0.01',
            'due_date'    => 'required|date',
            'category'    => 'nullable|string|max:100',
            'notes'       => 'nullable|string|max:1000',
        ]);

        $this->service->create($validated);

        return redirect()->route('payable.index')
            ->with('success', 'Conta a pagar criada com sucesso.');
    }

    public function markAsPaid(Request $request, int $id): RedirectResponse
    {
        $validated = $request->validate([
            'payment_date' => 'required|date',
        ]);

        $this->service->markAsPaid($id, $validated['payment_date']);

        return back()->with('success', 'Pagamento registrado com sucesso.');
    }

    public function destroy(int $id): RedirectResponse
    {
        $this->service->delete($id);

        return redirect()->route('payable.index')
            ->with('success', 'Conta a pagar removida.');
    }
}
